import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import React, { useState, useEffect } from 'react';
import { dibujaFlash } from '../Components/FlashMessage';
import { Head } from '@inertiajs/react';
import PdfViewer from '../Components/Pdf';
import Modal from '../Components/Modal';


//import bootstrap styles
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.js';

// import bootstrap react components
import Form from 'react-bootstrap/Form';
import Button from 'react-bootstrap/Button';
import { Inertia } from '@inertiajs/inertia';

export default function Dashboard({ auth }) {
  const [pdfData, setPdfData] = useState(null);
  const [showModal, setShowModal] = useState(false);

  //controla si se ha enviado el formulario de generación de nomina
  const handleSubmit = (e) => {
    e.preventDefault();
    fetchPdf();
    openModal();
  };
  
  //consulta la nomina con fech
  const fetchPdf = async () => {
    const response = await fetch('/generate');
    const blob = await response.blob();
    const url = URL.createObjectURL(blob);
    setPdfData(url);
  };
  
  //abrir el modal donde se vera la nomina
  const openModal = () => {
    setShowModal(true);
  };
  
  //cerrar el modal donde se vera la nomina
  const closeModal = () => {
    setShowModal(false);
  };
  
  return (
    <AuthenticatedLayout
    user={auth.user}
    header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>}
    >
      <Head title="Dashboard" />
      <div className="py-12">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            {<div className="p-6 text-gray-900 dark:text-gray-100">
              {console.log('dibujaFlash', dibujaFlash())}
              {dibujaFlash()}
              <h5>Bienvenido al visualizador de nominas por favor presione el boton para generar su nómina</h5>
              <br />
              <Form onSubmit={handleSubmit}>
                <div className=' justify-content-center text-center '>
                  <Button variant="secondary" type='submit'>Generar Ultima Nómina</Button>
                </div>
              </Form>
              <br />

              {/* modal */}
              {pdfData && (
                <Modal className='p-5 mw-100' show={showModal} onClose={closeModal} >
                  <div className='m-3 row'>
                    <h1 className='col-10 text-center'>Visor de Nóminas</h1>
                    <Button aria-label="Hide" className='col m-2 display-3' onClick={closeModal} variant="outline-danger">X</Button>
                  </div>
                  <PdfViewer pdfData={pdfData} ></PdfViewer>
                </Modal>
              )}

            </div>}
          </div>
        </div>
      </div>
      <footer className="bg-white dark:bg-gray-800 flex justify-center mt-2 px-6 sm:items-center sm:justify-center">
        <div className="ml-4 text-left text-sm text-gray-500 dark:text-gray-400 sm:text-left sm:ml-0 mt-4 mb-4">
          <span xmlns:dct="http://purl.org/dc/terms/" property="dct:title"><a rel="license" className="link-secondary" href="http://creativecommons.org/licenses/by-nc-nd/4.0/"><img alt="Licencia de Creative Commons" id='commons' src="https://i.creativecommons.org/l/by-nc-nd/4.0/88x31.png" /></a>Mi Nómina Online</span> by <a xmlns:cc="http://creativecommons.org/ns#" className="link-secondary" href="https://github.com/Pascal-Barros-Suarez" property="cc:attributionName" rel="cc:attributionURL">Pascal Barros Suarez</a> is licensed under a <a rel="license" className="link-secondary" href="http://creativecommons.org/licenses/by-nc-nd/4.0/">Creative Commons Reconocimiento-NoComercial-SinObraDerivada 4.0 Internacional License</a>.
        </div>

      </footer>
    </AuthenticatedLayout >
  );
}