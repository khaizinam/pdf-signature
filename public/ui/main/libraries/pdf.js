let pdfDoc = null;
let signatureImage = null;
let signatureX = 0;
let signatureY = 0;
let pdfCanvas = document.getElementById('pdf-canvas');
let ctx = pdfCanvas.getContext('2d');

// Load PDF and render it on canvas
document.getElementById('upload-pdf').addEventListener('change', async (event) => {
  const file = event.target.files[0];
  const arrayBuffer = await file.arrayBuffer();
  pdfDoc = await PDFLib.PDFDocument.load(arrayBuffer);
  
  // Use pdf.js to render the PDF on canvas
  const loadingTask = pdfjsLib.getDocument({ data: arrayBuffer });
  const pdf = await loadingTask.promise;
  const page = await pdf.getPage(1); // Load the first page
  const viewport = page.getViewport({ scale: 1.0 });

  // Resize canvas to match PDF page size
  pdfCanvas.width = viewport.width;
  pdfCanvas.height = viewport.height;

  const renderContext = {
    canvasContext: ctx,
    viewport: viewport,
  };
  await page.render(renderContext).promise;
});

// Load signature image
document.getElementById('upload-signature').addEventListener('change', (event) => {
  const file = event.target.files[0];
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
});

// Click on canvas to place signature
pdfCanvas.addEventListener('click', (event) => {
  const rect = pdfCanvas.getBoundingClientRect();
  signatureX = event.clientX - rect.left;
  signatureY = event.clientY - rect.top;

  // Draw signature on canvas
  if (signatureImage) {
    ctx.drawImage(signatureImage, signatureX, signatureY, 100, 50); // Kích thước chữ ký
  }
});

// Save the PDF with the signature
document.getElementById('save-pdf').addEventListener('click', async () => {
  if (!pdfDoc || !signatureImage) {
    alert("Chưa có tệp PDF hoặc chữ ký!");
    return;
  }

  const page = pdfDoc.getPage(0); // First page of the PDF

  // Embed the signature image in the PDF
  const signatureImageBytes = await fetch(signatureImage.src).then(res => res.arrayBuffer());
  const embeddedSignature = await pdfDoc.embedPng(signatureImageBytes);

  page.drawImage(embeddedSignature, {
    x: signatureX,
    y: page.getHeight() - signatureY - 50, // Adjust the Y position for the PDF coordinate system
    width: 100,
    height: 50,
  });

  // Save the new PDF
  const pdfBytes = await pdfDoc.save();
  const blob = new Blob([pdfBytes], { type: 'application/pdf' });
  const url = URL.createObjectURL(blob);

  // Create a link and trigger the download
  const a = document.createElement('a');
  a.href = url;
  a.download = 'signed_document.pdf';
  a.click();
});