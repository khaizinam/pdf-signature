<header>
    <div class="content-header container-content">
        <span class="contract-title">{{ $contract->name ?? '' }}</span>
        <span class="contract-date">{{ $contract->created_at ?? '' }}</span>
    </div>
</header>
<div class="container-content contract-wrapper" style="display:flex;justify-content:space-beweent;">
    <div class="left-content pdf-file">
        {{-- <div class="canva-draw"> --}}
        <canvas id="pdf-canvas" width="800" height="1200" ondrop="drop(event)" ondragover="allowDrop(event)"
            ondragleave="removeDropEffect(event)"></canvas>
        {{-- </div> --}}
    </div>
    <div class="right-content canvas-file">
        <div id="signature-pad" class="signature-pad">
            <div id="canvas-wrapper" class="signature-pad--body">
                <canvas width="600" style="touch-action: none; user-select: none;" height="600"></canvas>
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
                                <button type="button" class="button save btn btn-primary" id="save-signature">Lưu tạm
                                    chữ ký</button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <button type="button" class="button load btn btn-primary" id="load-signature">Tải chữ
                                    ký đã lưu</button>
                                <button type="button" class="button load btn btn-primary" id="prev-page">Trang trước</button>
                                <button type="button" class="button load btn btn-primary" id="next-page">Trang sau</button>
                            </div>
                        </div>

                        <input type="file" id="upload-signature" accept="image/*">
                    </div>
                    <div class="row mb-3">
                        <div class="input-group mb-3 col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Nhập tên</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Họ và tên" aria-label="Username"
                                aria-describedby="basic-addon1">
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
    let EMB_BUFFER = {};
    let curent_page = 1;
    const PDF_URL = '{{ get_object_image($contract->file ?? '') }}';
    const SIZE_EMBED = 120;
    const pdfCanvas = document.getElementById('pdf-canvas');
    const preBtn = document.getElementById('prev-page');
    const nextBtn = document.getElementById('next-page');
    const ctx = pdfCanvas.getContext('2d');
    let pdf;

    async function loadPDF(){
        const response = await fetch(PDF_URL);
        const arrayBuffer = await response.arrayBuffer();
        pdfDoc = await PDFLib.PDFDocument.load(arrayBuffer);
        // pdfDoc = await PDFLib.PDFDocument.load(arrayBuffer);
        const loadingTask = pdfjsLib.getDocument({
            data: arrayBuffer
        });
        pdf = await loadingTask.promise;
        // const totalPageCount = pdf.numPages;
        loadPdfFromUrl();
    }

    loadPDF();

    async function loadPdfFromUrl() {
        const page = await pdf.getPage(curent_page);

        const viewport = page.getViewport({
            scale: 1.0
        });

        pdfCanvas.width = viewport.width;
        pdfCanvas.height = viewport.height;
        const renderContext = {
            canvasContext: ctx,
            viewport: viewport
        };
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
                signatureX = event.clientX - rect.left - (SIZE_EMBED / 2); // Calculate X position
                signatureY = event.clientY - rect.top - (SIZE_EMBED / 2); // Calculate Y position
                ctx.drawImage(signatureImage, signatureX, signatureY, SIZE_EMBED, SIZE_EMBED); // Adjust size as needed

                if (!EMB_BUFFER[curent_page]) {
                    EMB_BUFFER[curent_page] = [];  // Initialize as an empty array if it doesn't exist
                }

                // Push the signature data for the current page
                EMB_BUFFER[curent_page].push({
                    signatureX: signatureX, // X coordinate of the signature
                    signatureY: signatureY  // Y coordinate of the signature
                });
            };


        }
    }

    pdfCanvas.addEventListener('dragover', allowDrop);
    // pdfCanvas.addEventListener('drop', drop);

    nextBtn.addEventListener('click', function(){
        curent_page += 1;
        loadPdfFromUrl();
    });

    preBtn.addEventListener('click', function(){
        curent_page -= 1;
        loadPdfFromUrl();
    });

    pdfCanvas.addEventListener('click', (event) => {
        if (signatureImage) {
            const rect = pdfCanvas.getBoundingClientRect();
            signatureX = event.clientX - rect.left - (SIZE_EMBED / 2);
            signatureY = event.clientY - rect.top  - (SIZE_EMBED / 2);;
            ctx.drawImage(signatureImage, signatureX, signatureY, SIZE_EMBED, SIZE_EMBED);
            console.log("pdfCanvas addEventListener click");
        } else {
            alert("Vui lòng tải chữ ký trước khi ký!");
        }
    });

    document.getElementById('save-pdf').addEventListener('click', async () => {
    const nameInput = document.querySelector('input[placeholder="Họ và tên"]');
    const name = nameInput.value.trim();

    if (!name) {
        alert("Vui lòng nhập họ và tên!");
        return;
    }

    if (!pdfDoc || !signatureImage) {
        alert("Chưa có tệp PDF hoặc chữ ký!");
        return;
    }

    const signatureImageBytes = await fetch(signatureImage.src).then(res => res.arrayBuffer());
    const embeddedSignature = await pdfDoc.embedPng(signatureImageBytes);

    // Iterate over EMB_BUFFER to embed the signature on each page
    for (const [pageNumber, signatures] of Object.entries(EMB_BUFFER)) {
        // Get the PDF page, note that PDF.js pages are 1-based, while arrays are 0-based
        const page = await pdfDoc.getPage(parseInt(pageNumber)-1);

        for (const signature of signatures) {
            const signatureImageBytes = await fetch(signatureImage.src).then(res => res.arrayBuffer());
            const embeddedSignature = await pdfDoc.embedPng(signatureImageBytes);

            // Draw each signature on the PDF page
            page.drawImage(embeddedSignature, {
                x: signature.signatureX, // X position of the signature
                y: page.getHeight() - signature.signatureY - (SIZE_EMBED / 2), // Y position, adjusted for PDF's coordinate system
                width: SIZE_EMBED,       // Signature width
                height: SIZE_EMBED       // Signature height
            });
        }
    }

    const pdfBytes = await pdfDoc.save();
    const blob = new Blob([pdfBytes], {
        type: 'application/pdf'
    });
    const url = URL.createObjectURL(blob);

    // Tải xuống PDF
    const a = document.createElement('a');
    a.href = url;
    a.download = 'signed_document.pdf';
    a.click();

    // Bước 2: Lưu chữ ký và thông tin vào cơ sở dữ liệu
    const formData = new FormData();
    formData.append('name', name);
    formData.append('file', blob); // Chuyển đổi blob sang file
    formData.append('contract_id', '{{ $contract->id }}'); // Thêm contract_id vào FormData

    fetch('/save-signature-contract', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Chữ ký và thông tin hợp đồng đã được lưu thành công!");
            } else {
                alert("Lưu chữ ký không thành công.");
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
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
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                },
                body: JSON.stringify({
                    image: signaturePad
                })
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

    // loadPdfFromUrl();
</script>
