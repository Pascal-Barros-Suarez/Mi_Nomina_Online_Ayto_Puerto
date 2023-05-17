import React from 'react';
import { dibujaFlash } from '../Components/FlashMessage';


const PdfViewer = (props) => {
  return (
    <object data={props.pdfData} type="application/pdf" className='w-100' height='87%'></object>
  );
};

export default PdfViewer; 