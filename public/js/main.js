$(document).ready(function () {
    // Funkcija za slanje GET zahteva BE API-ju
    function getApiData() {
        $.ajax({
            type: 'GET',
            url: '/api/endpoint', // Zamenite sa pravim URL-om vašeg BE API-ja
            success: function (response) {
                // Obrada odgovora sa servera
                console.log(response);
            },
            error: function (error) {
                // Obrada greške
                console.error("Došlo je do greške pri slanju zahteva na server.");
            }
        });
    }

    // Funkcija za slanje POST zahteva BE API-ju
    function postApiData(data) {
        $.ajax({
            type: 'POST',
            url: '/api/endpoint', // Zamenite sa pravim URL-om vašeg BE API-ja
            data: data, // Podaci koje šaljete na server
            success: function (response) {
                // Obrada uspešnog odgovora sa servera
                console.log(response);
            },
            error: function (error) {
                // Obrada greške
                console.error("Došlo je do greške pri slanju zahteva na server.");
            }
        });
    }

    // Primeri korišćenja funkcija za slanje zahteva
    getApiData();

    var postData = {
        key: 'value'
    };
    postApiData(postData);
});
