import { usePage } from "@inertiajs/react";
import Toast from 'react-bootstrap/Toast';
import React, { useState } from 'react';

export function dibujaFlash(flash) {
  const [show, setShow] = useState(true);
  let message;

  if (flash.success) {
    message = (
      <>
        <Toast
          className="d-inline-block m-1 rounded-5"
          bg="success"
          key="alert_flash"
          onClose={() => setShow(false)}
          show={show}
          delay={7050}
          autohide
        >
          <div className="d-flex justify-content-between">
            <Toast.Body>
              <h5 className="fa fa-flash text-white">{flash.success}</h5>
            </Toast.Body>
            <button
              type="button"
              className="btn-close btn-close-white me-2 m-auto"
              data-bs-dismiss="toast"
              aria-label="Close"
            ></button>
          </div>
        </Toast>
        <br />
      </>
    );
  } else if (flash.error) {
    message = (
      <>
        <Toast
          className="d-inline-block m-1 rounded-5"
          bg="danger"
          key="alert_flash"
          onClose={() => setShow(false)}
          show={show}
          delay={7050}
          autohide
        >
          <div className="d-flex justify-content-between">

            <Toast.Body>
              <h5 className="fa fa-flash text-white">{flash.error}</h5>
            </Toast.Body>
            <button
              type="button"
              className="btn-close btn-close-white me-2 m-auto"
              data-bs-dismiss="toast"
              aria-label="Close"
            ></button>
          </div>
        </Toast>
        <br />
      </>
    );
  }

  return message;
}
