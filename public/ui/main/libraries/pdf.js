let pdfDoc = null;
let signatureImage = null;
let signatureX = 0;
let signatureY = 0;
let EMB_BUFFER = {};
let curent_page = 1;
let totalPageCount = 0;
let pdf;

const SIZE_EMBED = 120;
const PDF_URL = document.getElementById('pdf-url').value;
const pdfCanvas = document.getElementById('pdf-canvas');
const preBtn = document.getElementById('prev-page');
const nextBtn = document.getElementById('next-page');
const domCurrentPage = document.getElementById('current-page');
const domTotalPage = document.getElementById('total-page');
const ctx = pdfCanvas.getContext('2d');
domCurrentPage.innerText = curent_page;
// Load pdf lên màn hình khi vào trang
async function loadPDF(){
    const response = await fetch(PDF_URL);
    const arrayBuffer = await response.arrayBuffer();
    pdfDoc = await PDFLib.PDFDocument.load(arrayBuffer);
    const loadingTask = pdfjsLib.getDocument({
        data: arrayBuffer
    });
    pdf = await loadingTask.promise;
    totalPageCount = pdf.numPages;
    domTotalPage.innerText = totalPageCount;
    reloadPagePDF();
}

loadPDF();

// render pdf lên canvas
async function reloadPagePDF() {
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
    domCurrentPage.innerText = curent_page;
    await page.render(renderContext).promise;
}

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

nextBtn.addEventListener('click', function(){
    curent_page += 1;
    if(curent_page > totalPageCount)
        curent_page = totalPageCount;
    else
        reloadPagePDF();
});

preBtn.addEventListener('click', function(){
    curent_page -= 1;
    if(curent_page < 1)
        curent_page = 1;
    else{
        reloadPagePDF();
    }
});

// Bấm vào pdf để chèn chữ ký vào vị trí đã  chọn
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

// Bấm Lưu PDF
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
                signatureImage = new Image();
                signatureImage.src = data.image;
            } else {
                alert("Tải chữ ký không thành công.");
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
});
