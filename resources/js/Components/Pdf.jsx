import React from 'react';
import { dibujaFlash } from '../Components/FlashMessage';


const PdfViewer = (props) => {
  return (
    <>
      {dibujaFlash()}
      <div className='h-100'>
        <object data={props.pdfData} type="application/pdf" className='w-100' height="700px"></object>
      </div>
    </>
  );
};

export default PdfViewer; 