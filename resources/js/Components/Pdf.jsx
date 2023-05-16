import React from 'react';
import { Document, Page } from 'react-pdf';
import pdfjs from 'pdfjs-dist/build/pdf';

pdfjs.GlobalWorkerOptions.workerSrc = publicPath + '/build/pdf.worker.js';

const PdfViewer = (props) => {
  return (
    <div>
      <h1>PDF Viewer</h1>
      <Document file={props.pdfData}>
        <Page pageNumber={1} />
      </Document>
    </div>
  );
};

export default PdfViewer;
