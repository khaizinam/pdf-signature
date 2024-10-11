<header>
    <div class="content-header container-content">
        <span class="contract-title">{{ $contract->name ?? "" }}</span>
        <span class="contract-date">{{ $contract->created_at ?? "" }}</span>
    </div>
</header>
<div class="container-content contract-wrapper" style="display:flex;justify-content:space-beweent;">
    <div class="left-content pdf-file">
        <div class="canva-draw">
            <canvas id="pdf-canvas" width="797" height="1129"
                    ondrop="drop(event)"
                    ondragover="allowDrop(event)"
                    ondragleave="removeDropEffect(event)"></canvas>
        </div>
    </div>
    <div class="right-content canvas-file">
        <div id="signature-pad" class="signature-pad">
            <div id="canvas-wrapper" class="signature-pad--body">
                <canvas width="660" style="touch-action: none; user-select: none;" height="200"></canvas>
            </div>
            <div class="signature-pad--footer">
                <div class="description">
                    Ký ở trên
                </div>
                <img id="loaded-signature" src="" alt="Loaded Signature" style="display:none;" />
                <div class="signature-pad--actions container">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="row container">
                                <button type="button" class="button clear btn btn-primary" data-action="clear">
                                    Xoá
                                </button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row container">
                                <button type="button" class="button save btn btn-primary" data-action="save-png">
                                    Tải xuống
                                </button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <button type="button" class="button save btn btn-primary" id="save-signature">Save Signature to Storage</button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <button type="button" class="button load btn btn-primary" id="load-signature">Load Signature</button>
                            </div>
                        </div>

                        <input type="file" id="upload-signature" accept="image/*">
                    </div>
                    <div class="row mb-3">
                        <div class="input-group mb-3 col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Nhập tên</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Họ và tên" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                    </div>
                    <div class="row">
                        <button id="save-pdf" class="btn btn-primary">
                            Lưu PDF với chữ ký
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let pdfDoc = null;
    let signatureImage = null;
    var signatureX = 0;
    var signatureY = 0;
    const pdfCanvas = document.getElementById('pdf-canvas');
    const ctx = pdfCanvas.getContext('2d');

    async function loadPdfFromUrl(pdfUrl) {
        const response = await fetch(pdfUrl);
        const arrayBuffer = await response.arrayBuffer();
        pdfDoc = await PDFLib.PDFDocument.load(arrayBuffer);
        const loadingTask = pdfjsLib.getDocument({ data: arrayBuffer });
        const pdf = await loadingTask.promise;
        const page = await pdf.getPage(1);
        const viewport = page.getViewport({ scale: 1.0 });
        pdfCanvas.width = viewport.width;
        pdfCanvas.height = viewport.height;
        const renderContext = { canvasContext: ctx, viewport: viewport };
        await page.render(renderContext).promise;
    }

    // document.getElementById('upload-signature').addEventListener('change', (event) => {
    //     const file = event.target.files[0];
    //     if (file) {
    //         const reader = new FileReader();
    //         reader.onload = (e) => {
    //             const img = new Image();
    //             img.src = e.target.result;
    //             img.onload = () => {
    //                 signatureImage = img;
    //                 alert("Chữ ký đã sẵn sàng, nhấn vào vị trí cần ký trên PDF!");
    //             };
    //         };
    //         reader.readAsDataURL(file);
    //     } else {
    //         alert("Không có tệp nào được chọn!");
    //     }
    // });
    function drag(event) {
    event.dataTransfer.setData("text/plain", event.target.src);
    }

    // Allow the drop on the PDF canvas
    function allowDrop(event) {
        event.preventDefault();
    }
    function drop(event) {
        event.preventDefault();
        const signatureSrc = event.dataTransfer.getData("text/plain");

        if (signatureSrc) {
            signatureImage = new Image();
            signatureImage.src = signatureSrc;

            // Draw the signature on the PDF canvas where the user drops it
            signatureImage.onload = () => {
                const rect = pdfCanvas.getBoundingClientRect();
                signatureX = event.clientX - rect.left; // Calculate X position
                signatureY = event.clientY - rect.top;  // Calculate Y position
                ctx.drawImage(signatureImage, signatureX, signatureY, 100, 50); // Adjust size as needed
                console.log("khi dán vao`", signatureX, signatureY);
            };
        }
    }
    pdfCanvas.addEventListener('dragover', allowDrop);
    pdfCanvas.addEventListener('drop', drop);

    pdfCanvas.addEventListener('click', (event) => {
        if (signatureImage) {
            const rect = pdfCanvas.getBoundingClientRect();
            signatureX = event.clientX - rect.left;
            signatureY = event.clientY - rect.top;
            console.log("Khi click vao pdf",signatureX, signatureY);
            ctx.drawImage(signatureImage, signatureX, signatureY, 100, 50);
        } else {
            alert("Vui lòng tải chữ ký trước khi ký!");
        }
    });

    document.getElementById('save-pdf').addEventListener('click', async () => {
        if (!pdfDoc || !signatureImage) {
            alert("Chưa có tệp PDF hoặc chữ ký!");
            return;
        }

        const page = pdfDoc.getPage(0);
        const signatureImageBytes = await fetch(signatureImage.src).then(res => res.arrayBuffer());
        const embeddedSignature = await pdfDoc.embedPng(signatureImageBytes);
        console.log("khi luu file", signatureX, signatureY);

        page.drawImage(embeddedSignature, {
            x: signatureX,
            y: page.getHeight() - signatureY - 50,
            width: 100,
            height: 50,
        });
        console.log("sau khi luu file",signatureX,signatureY);

        console.log("page get height",page.getHeight());

        const pdfBytes = await pdfDoc.save();
        const blob = new Blob([pdfBytes], { type: 'application/pdf' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'signed_document.pdf';
        a.click();
    });

    document.getElementById('save-signature').addEventListener('click', () => {
        const signaturePad = document.querySelector('.signature-pad canvas').toDataURL();
        if (!signaturePad) {
            alert("Vui lòng cung cấp chữ ký trước.");
            return;
        }

        fetch('/save-signature', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ image: signaturePad })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Chữ ký đã được lưu vào storage!");
            } else {
                alert("Lưu chữ ký không thành công.");
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    document.getElementById('load-signature').addEventListener('click', () => {
        fetch('/load-signature')
            .then(response => response.json())
            .then(data => {
                if (data.image) {
                    const img = document.getElementById('loaded-signature');
                    img.src = data.image;
                    img.style.display = 'block'; // Hiện chữ ký đã tải
                } else {
                    alert("Tải chữ ký không thành công.");
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });

    loadPdfFromUrl('{{ get_object_image($contract->file ?? '') }}');
</script>
