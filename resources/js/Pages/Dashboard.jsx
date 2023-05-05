import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.js';

export default function Dashboard({ auth }) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>}
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        {<div className="p-6 text-gray-900 dark:text-gray-100">You're logged in! <br></br>Now You can view your payrolls</div>}
                    </div>
                </div>
            </div>
            <footer className="bg-white dark:bg-gray-800 flex justify-center mt-2 px-6 sm:items-center sm:justify-center">
                <div className="ml-4 text-left text-sm text-gray-500 dark:text-gray-400 sm:text-left sm:ml-0 mt-4 mb-4">
                    <span xmlns:dct="http://purl.org/dc/terms/" property="dct:title"><a rel="license" className="link-secondary" href="http://creativecommons.org/licenses/by-nc-nd/4.0/"><img alt="Licencia de Creative Commons" id='commons' src="https://i.creativecommons.org/l/by-nc-nd/4.0/88x31.png" /></a>Mi Nómina Online</span> by <a xmlns:cc="http://creativecommons.org/ns#" className="link-secondary" href="https://github.com/Pascal-Barros-Suarez" property="cc:attributionName" rel="cc:attributionURL">Pascal Barros Suarez</a> is licensed under a <a rel="license" className="link-secondary" href="http://creativecommons.org/licenses/by-nc-nd/4.0/">Creative Commons Reconocimiento-NoComercial-SinObraDerivada 4.0 Internacional License</a>.
                </div>

            </footer>
        </AuthenticatedLayout>
    );
}
