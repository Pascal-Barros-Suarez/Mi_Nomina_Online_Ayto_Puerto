import React from 'react';


const PdfViewer = (props) => {
  return (
    <div className='h-100'>
      <h1 className='text-center'>Visor de Nómina</h1>
      <object data={props.pdfData} type="application/pdf" width="100%" height="1000px"></object>

    </div>
  );
};

export default PdfViewer; 