<div class="content" style="display:flex;justify-content:space-between;">
    <div class="pdf-file">
        <input type="file" id="upload-signature" accept="image/*">

        <!-- Canvas to show PDF page -->
        <canvas id="pdf-canvas" width="500" height="700"
                ondrop="drop(event)"
                ondragover="allowDrop(event)"
                ondragleave="removeDropEffect(event)"></canvas>

        <!-- Save PDF button -->
        <div id="controls">
            <button id="save-pdf">Lưu PDF với chữ ký</button>
        </div>
    </div>
    <div class="canvas-file">
        <div id="signature-pad" class="signature-pad">
            <div id="canvas-wrapper" class="signature-pad--body">
                <canvas width="660" style="touch-action: none; user-select: none;" height="200"></canvas>
            </div>
            <div class="signature-pad--footer">
                <div class="description">Sign above</div>

                <div class="signature-pad--actions">
                    <div class="column">
                        <button type="button" class="button clear" data-action="clear">Clear</button>
                        <button type="button" class="button" data-action="undo" title="Ctrl-Z">Undo</button>
                        <button type="button" class="button" data-action="redo" title="Ctrl-Y">Redo</button>
                        <br />
                        <button type="button" class="button" data-action="change-color">Change color</button>
                        <button type="button" class="button" data-action="change-width">Change width</button>
                        <button type="button" class="button" data-action="change-background-color">Change background color</button>
                    </div>
                    <div class="column">
                        <button type="button" class="button save" data-action="save-png">Save as PNG</button>
                        <button type="button" class="button save" data-action="save-jpg">Save as JPG</button>
                        <button type="button" class="button save" data-action="save-svg">Save as SVG</button>
                        <button type="button" class="button save" data-action="save-svg-with-background">Save as SVG with background</button>
                    </div>
                </div>

                <div>
                    <button type="button" class="button" data-action="open-in-window">Open in Window</button>
                </div>
                <button type="button" class="button save" id="save-signature">Save Signature to Storage</button>
                <button type="button" class="button load" id="load-signature">Load Signature</button>
                <img id="loaded-signature" src="" alt="Loaded Signature" style="display:none;" />
            </div>
        </div>
    </div>
</div>


<script>
    let pdfDoc = null;
    let signatureImage = null;
    let signatureX = 0;
    let signatureY = 0;
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

    document.getElementById('upload-signature').addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                const img = new Image();
                img.src = e.target.result;
                img.onload = () => {
                    signatureImage = img;
                    alert("Chữ ký đã sẵn sàng, nhấn vào vị trí cần ký trên PDF!");
                };
            };
            reader.readAsDataURL(file);
        } else {
            alert("Không có tệp nào được chọn!");
        }
    });

    pdfCanvas.addEventListener('click', (event) => {
        if (signatureImage) {
            const rect = pdfCanvas.getBoundingClientRect();
            signatureX = event.clientX - rect.left;
            signatureY = event.clientY - rect.top;
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
        page.drawImage(embeddedSignature, {
            x: signatureX,
            y: page.getHeight() - signatureY - 50,
            width: 100,
            height: 50,
        });

        const pdfBytes = await pdfDoc.save();
        const blob = new Blob([pdfBytes], { type: 'application/pdf' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'signed_document.pdf';
        a.click();
    });

    loadPdfFromUrl('{{ get_object_image($contract->file ?? '') }}');

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
</script>
