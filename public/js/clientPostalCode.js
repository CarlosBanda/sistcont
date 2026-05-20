document.addEventListener("DOMContentLoaded", function () {

    const input = document.querySelector("#cp_input");

    input.addEventListener("input", async function () {

        if (this.value.length === 5) {

            const url = `https://api.copomex.com/query/info_cp/${this.value}?token=46556d12-eb2c-4cf1-acf6-0a2576978306`;

            const response = await fetch(url);
            const data = await response.json();

            const select = document.getElementById("colonia_input");
            data.forEach(item => {

                const asentamiento = item.response.asentamiento;

                const option = document.createElement("option");

                document.getElementById("state_input").value = data[0].response.estado;
                document.getElementById("city_input").value = data[0].response.ciudad;
                document.getElementById("country_input").value = data[0].response.pais;
                option.value = asentamiento;
                option.textContent = asentamiento;

                select.appendChild(option);

            });

            console.log(data);

        }

    });

});