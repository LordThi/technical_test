import React, {useEffect, useState} from 'react';
import Login from "./components/Login.jsx";
import Footer from "./components/Footer.jsx";
import Instructions from "./components/Instructions.jsx";

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
        if (candidat.firstname.length && candidat.lastname && candidat.mail)
            setLogged(true)
    };

    return (
        <div>
            {!isLogged && <Login handleCandidat={handleCandidat}/>}
            {isLogged && <Instructions companyName={companyName} candidat={candidat}/>}
            <Footer companyName={companyName}/>
        </div>
    );
}

export default App;