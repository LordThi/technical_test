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

    const company = data ? data.company : null;

    const handleCandidat = (candidat) => {
        console.log('le candidat est: ', candidat);
        setCandidat(candidat);
        if (candidat.firstname.length && candidat.lastname && candidat.mail)
            setLogged(true)
    };

    return (
        <div>
            {console.log(data)}
            {console.log(candidat)}
            {!isLogged && <Login handleCandidat={handleCandidat}/>}
            {isLogged && <Instructions/>}
            <Footer company={company}/>
        </div>
    );
}

export default App;