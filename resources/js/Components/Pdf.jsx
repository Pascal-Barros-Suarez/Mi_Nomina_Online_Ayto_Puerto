import React from 'react';
import { Document, Page } from 'react-pdf';

const PdfViewer = () => {
  return (
    <div>
      <h1>PDF Viewer</h1>
      <Document
        file={pdfData}
      >
        <Page pageNumber={1} />
      </Document>
    </div>
  );
};

export default PdfViewer;