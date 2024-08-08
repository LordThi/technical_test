// src/App.jsx
// eslint-disable-next-line no-unused-vars
import React, { useEffect, useState } from 'react';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import Login from "./components/Login.jsx";
import Footer from "./components/Footer.jsx";
import Instructions from "./components/Instructions.jsx";
import AdminDashboard from "./components/Admin/AdminDashboard.jsx";

function App() {
    const [data, setData] = useState(null);
    const [candidat, setCandidat] = useState({});
    const [isLogged, setLogged] = useState(false);

    useEffect(() => {
        fetch('/api/data')
            .then(response => response.json())
            .then(data => setData(data))
            .catch(error => console.error('Error fetching data:', error));
    }, []);

    const companyName = data?.company?.name || null;

    const handleCandidat = (candidat) => {
        setCandidat(candidat);
        if (candidat.prenom.length && candidat.nom && candidat.email)
            setLogged(true);
    };

    return (
        <Router>
            <Routes>
                <Route path="/admin" element={<AdminDashboard />} />
                <Route path="/" element={
                    <>
                        {!isLogged && <Login handleCandidat={handleCandidat} />}
                        {isLogged && <Instructions companyName={companyName} candidat={candidat} />}
                    </>
                } />
            </Routes>
            <Footer companyName={companyName} />
        </Router>
    );
}

export default App;
