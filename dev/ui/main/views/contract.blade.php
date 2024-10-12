<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>

<body>

    <header>
        <div class="content-header container-content">
            <span class="contract-title">{{ $contract->name ?? '' }}</span>
            <span class="contract-date">{{ $contract->created_at ?? '' }}</span>
        </div>
    </header>
    <div class="container-content contract-wrapper sig-wrap" style="display:flex;justify-content:space-beweent;">
        <div class="left-content pdf-file">
            {{-- <div class="canva-draw"> --}}
            <canvas id="pdf-canvas" width="800" height="1200" ondrop="drop(event)" ondragover="allowDrop(event)"
                ondragleave="removeDropEffect(event)"></canvas>
            {{-- </div> --}}
        </div>
        <div class="right-content canvas-file" id="menu">
            <div id="signature-pad" class="signature-pad">
                <!-- Button trigger modal -->
                <button type="button" class="sig-btn mb-3" data-toggle="modal" data-target="#exampleModal">
                    <div class="icon-sig" style="width: 40px; height: 40px;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M16.585 4.126c.618 2.53-.564 4.49-3.442 5.882q-.302 1.22-.625 2.66.437-.212.933-.426a69 69 0 0 1 1.71-.705c1.432-.582 2.309-.591 2.22.423-.038.425-.308.851-1.023 1.8l-.058.077c-.31.41-.306.407-.407.544q-.371.506-.733.989.633-.37 1.484-.89c1.357-.83 2.386-1.251 3.137-1.251.94 0 1.447.644 1.424 1.688l-1-.022c.011-.526-.099-.666-.424-.666-.516 0-1.405.363-2.616 1.104-1.294.79-2.22 1.329-2.787 1.618-.325.165-.538.255-.702.282-.303.048-.635-.068-.65-.502-.006-.188.058-.303.172-.444a98 98 0 0 0 1.888-2.497c.096-.13.102-.139.338-.452l.136-.18q.459-.61.66-.938-.27.076-.684.243a73 73 0 0 0-1.689.697 18 18 0 0 0-1.61.777l-.058.267q-.541 2.216-1.146 3.797L21 18v1H10.614c-.752 1.625-1.585 2.574-2.531 2.852-.715.209-1.3.048-1.586-.498-.217-.416-.212-.985-.04-1.675q.08-.326.209-.678L3 19v-1h4.096a11.8 11.8 0 0 1 1.947-2.818 10.3 10.3 0 0 1 2.312-1.89q.33-1.504.639-2.793-1.606.609-3.738 1.038l-.197-.98c1.695-.342 3.101-.757 4.227-1.247q.923-3.665 1.65-5.289c.92-2.052 2.126-2.038 2.65.105M9.502 19H7.738a6.4 6.4 0 0 0-.31.92c-.119.474-.122.822-.044.97.034.067.118.09.418.002.568-.167 1.14-.798 1.7-1.892m1.512-4.271a9.7 9.7 0 0 0-1.238 1.134q-.232.247-.462.526a11 11 0 0 0-1.089 1.61l1.73.002q.547-1.334 1.06-3.272M6.335 12l.666.667L5.667 14 7 15.333 6.333 16 5 14.667 3.667 16 3 15.333 4.333 14 3 12.667 3.667 12 5 13.333zm8.515-7.57q-.604 1.35-1.374 4.274c1.879-1.131 2.57-2.579 2.139-4.34-.284-1.164-.215-1.163-.765.066">
                            </path>
                        </svg>
                    </div>
                    Chữ ký của bạn
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <svg width="30" height="30" viewBox="0 0 39 39" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="0.5" y="0.5" width="38" height="38" rx="19"
                                            fill="white"></rect>
                                        <rect x="0.5" y="0.5" width="38" height="38" rx="19"
                                            stroke="#FFB700"></rect>
                                        <path
                                            d="M24.96 15.1398L23.8602 14.04L19.5 18.4002L15.1398 14.04L14.04 15.1398L18.4002 19.5L14.04 23.8602L15.1398 24.96L19.5 20.5998L23.8602 24.96L24.96 23.8602L20.5998 19.5L24.96 15.1398Z"
                                            fill="#FFB700"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div id="canvas-wrapper" class="signature-pad--body">
                                    <canvas width="660" style="touch-action: none; user-select: none;"
                                        height="200"></canvas>
                                </div>
                                <div class="signature-pad--footer">
                                    <div class="description">
                                        Ký ở trên
                                    </div>
                                    <img id="loaded-signature" src="" alt="Loaded Signature"
                                        style="display:none;" />

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="button clear btn btn-primary" data-action="clear">
                                    Xoá
                                </button>
                                <button type="button" class="button save btn btn-primary" data-action="save-png">
                                    Tải xuống
                                </button>
                                <button type="button" class="button save btn btn-primary" id="save-signature">Save
                                    Signature to Storage</button>
                                <button type="button" class="button load btn btn-primary" id="load-signature">Load
                                    Signature</button>

                                <input type="file" id="upload-signature" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="signature-pad--actions container">
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
                        <button id="save-pdf" class="sig-btn">
                            <div class="pdf-icon">
                                PDF
                            </div>
                            Lưu PDF với chữ ký
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="mobile">
            <div class="header__logo__right">
                <div class="header__logo__hamb" id="menuToggle">
                    <svg class="menuToggle" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 12H21M3 6H21M3 18H21" stroke="#344054" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        
                    <svg class="cancelMenu" style="display: none;" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 5.99994L6 17.9999M6 5.99994L18 17.9999" stroke="#E9BB09" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        
                </div>
            </div>
        </div>
    </div>


    <script>
        let pdfDoc = null;
        let signatureImage = null;
        var signatureX = 0;
        var signatureY = 0;
        var pos = [];
        const pdfCanvas = document.getElementById('pdf-canvas');
        const ctx = pdfCanvas.getContext('2d');

        async function loadPdfFromUrl(pdfUrl) {
            const response = await fetch(pdfUrl);
            const arrayBuffer = await response.arrayBuffer();
            pdfDoc = await PDFLib.PDFDocument.load(arrayBuffer);
            const loadingTask = pdfjsLib.getDocument({
                data: arrayBuffer
            });
            const pdf = await loadingTask.promise;
            const page = await pdf.getPage(1);
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
                    signatureX = event.clientX - rect.left; // Calculate X position
                    signatureY = event.clientY - rect.top; // Calculate Y position
                    ctx.drawImage(signatureImage, signatureX, signatureY, 100, 50); // Adjust size as needed
                    pos.push({
                        signatureX,
                        signatureY
                    });
                };


            }
        }
        pdfCanvas.addEventListener('dragover', allowDrop);
        // pdfCanvas.addEventListener('drop', drop);

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

            pos.forEach((el, index) => {
                console.log("el", el);

                page.drawImage(embeddedSignature, {
                    x: el.signatureX,
                    y: page.getHeight() - el.signatureY - 50,
                    width: 100,
                    height: 50,
                });
            })


            const pdfBytes = await pdfDoc.save();
            const blob = new Blob([pdfBytes], {
                type: 'application/pdf'
            });
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

        // Sự kiện khi modal được hiển thị
        $('#exampleModal').on('shown.bs.modal', function() {
            const canvas = document.querySelector('#canvas-wrapper canvas');
            const context = canvas.getContext('2d');

            // Đặt kích thước canvas
            canvas.width = 660; // Hoặc chiều rộng bạn mong muốn
            canvas.height = 200; // Hoặc chiều cao bạn mong muốn

            // Xóa canvas hoặc thực hiện khởi tạo cần thiết
            context.clearRect(0, 0, canvas.width, canvas.height);
        });

        // Khi modal bị đóng, xóa canvas
        $('#exampleModal').on('hidden.bs.modal', function() {
            const canvas = document.querySelector('#canvas-wrapper canvas');
            const context = canvas.getContext('2d');
            context.clearRect(0, 0, canvas.width, canvas.height); // Xóa canvas
        });

        $(document).on("click","#menuToggle",function(){
            $("#menu").toggleClass("menu-transfom");
            $(".menuToggle").toggle();
            $(".cancelMenu").toggle();
        });

        loadPdfFromUrl('{{ get_object_image($contract->file ?? '') }}');
    </script>
</div>
<input type="hidden" name="url-pdf" id="pdf-url" value="{{ get_object_image(Arr::get($contract, 'file', '')) }}">
