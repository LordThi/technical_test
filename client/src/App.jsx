import React, { useEffect, useState } from 'react';
import Login from "./components/Login.jsx";

function App() {
    const [data, setData] = useState(null);

    useEffect(() => {
        fetch('/api/data')
            .then(response => response.json())
            .then(data => setData(data))
            .catch(error => console.error('Error fetching data:', error));
    }, []);

    return (
        <div>
            <Login/>
        </div>
    );
}

export default App;
