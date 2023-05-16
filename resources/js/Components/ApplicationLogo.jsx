import logoAYTO from '/public/media/img/logo.png';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.js';
// import { Container } from 'bootstrap';

export default function ApplicationLogo(props) {
    return (
        <img {...props} src={logoAYTO} alt="AYTO" />
    );
}

