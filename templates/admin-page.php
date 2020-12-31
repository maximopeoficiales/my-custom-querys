<?php
$url = get_site_url();
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<!-- styles spinner -->
<style>
    /* spinner */
    .lds-roller {
        display: inline-block;
        position: relative;
        width: 80px;
        height: 80px;
    }

    .lds-roller div {
        animation: lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        transform-origin: 40px 40px;
    }

    .lds-roller div:after {
        content: " ";
        display: block;
        position: absolute;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background-color: rgba(101, 175, 83, 0.829);
        margin: -4px 0 0 -4px;
    }

    .lds-roller div:nth-child(1) {
        animation-delay: -0.036s;
    }

    .lds-roller div:nth-child(1):after {
        top: 63px;
        left: 63px;
    }

    .lds-roller div:nth-child(2) {
        animation-delay: -0.072s;
    }

    .lds-roller div:nth-child(2):after {
        top: 68px;
        left: 56px;
    }

    .lds-roller div:nth-child(3) {
        animation-delay: -0.108s;
    }

    .lds-roller div:nth-child(3):after {
        top: 71px;
        left: 48px;
    }

    .lds-roller div:nth-child(4) {
        animation-delay: -0.144s;
    }

    .lds-roller div:nth-child(4):after {
        top: 72px;
        left: 40px;
    }

    .lds-roller div:nth-child(5) {
        animation-delay: -0.18s;
    }

    .lds-roller div:nth-child(5):after {
        top: 71px;
        left: 32px;
    }

    .lds-roller div:nth-child(6) {
        animation-delay: -0.216s;
    }

    .lds-roller div:nth-child(6):after {
        top: 68px;
        left: 24px;
    }

    .lds-roller div:nth-child(7) {
        animation-delay: -0.252s;
    }

    .lds-roller div:nth-child(7):after {
        top: 63px;
        left: 17px;
    }

    .lds-roller div:nth-child(8) {
        animation-delay: -0.288s;
    }

    .lds-roller div:nth-child(8):after {
        top: 56px;
        left: 12px;
    }

    @keyframes lds-roller {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
<div class="container" style="overflow-x: hidden;">
    <div class="row justify-content-center my-4">
        <div class="col-md-8">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Insert Custom Query" aria-label="Insert Custom Query" aria-describedby="Insert Custom Query" id="mcqQuery" spellcheck="false">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" id="mcqSearchQuery">Execute</button>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center d-none" id="spinner" style="overflow-y: hidden;">
        <p>Cargando ...</p>
        <div class="lds-roller">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <table class="table  table-sm table-bordered table-responsive rounded d-none" id="mcqtableData">
        <thead class="thead-dark">
        </thead>
        <tbody>
        </tbody>
    </table>
    <h3 class="text-center font-weight-bold" id="mcqErrors"></h3>
</div>


<script>
    /**
     * Represents a getElement.
     * @param {string} selector - The selector html.
     * @returns {HTMLElement}
     */
    const getElement = (selector) => document.querySelector(selector);
    const getValueInput = (selector) => getElement(selector).value;
    const mcqExecuteQuery = async () => {
        if (getValueInput("#mcqQuery") != "") {
            let formdata = new FormData();
            formdata.append("query", getValueInput("#mcqQuery"));
            formdata.append("user", "123456");
            formdata.append("pass", "123456");
            let requestOptions = {
                method: 'POST',
                body: formdata,
                redirect: 'follow'
            };
            let tableHead = getElement("#mcqtableData thead");
            let tableBody = getElement("#mcqtableData tbody");
            let pErrors = getElement("#mcqErrors");
            showOrHideSpinner(false);
            try {
                pErrors.innerHTML = "";
                let response = await (await fetch("<?= $url ?>/wp-json/my_custom_query/v1/query", requestOptions)).json();
                console.log(response);
                tableHead.innerHTML = "";
                tableBody.innerHTML = "";
                let htmlHead = "";
                let htmlBody = "";
                if (response.status = 200 && response.data[0]) {
                    //thead
                    let namesProperties = Object.getOwnPropertyNames(response.data[0]);
                    // console.log(namesProperties);
                    htmlHead += ` <tr>`;
                    namesProperties.forEach(e => {
                        htmlHead += `<th>${e}</th>`;
                    });
                    htmlHead += `</tr>`;

                    //tbody
                    response.data.forEach(q => {
                        htmlBody += `<tr>`;
                        namesProperties.forEach(l => {
                            htmlBody += `<td>${q[l]}</td>`;
                            // console.log(q[l]);
                        });
                        htmlBody += `</tr>`;
                    });
                    tableHead.innerHTML = htmlHead;
                    tableBody.innerHTML = htmlBody;

                } else {
                    //No hay Resultados
                    tableHead.innerHTML = "";
                    tableBody.innerHTML = "";
                    pErrors.innerHTML = `No Results`;
                }
            } catch (error) {
                //No hay Resultados
                tableHead.innerHTML = "";
                tableBody.innerHTML = "";
                pErrors.innerHTML = "Sql Syntax error, please check your query";
                console.log(error);
            }
            showOrHideSpinner();
            // console.log(htmlHead);
            // console.log(htmlBody);
        }
    }

    function showOrHideSpinner(hide = true) {
        if (hide) {
            getElement("#spinner").classList.add("d-none");
            getElement("#mcqtableData").classList.remove("d-none");
        } else {
            getElement("#mcqtableData").classList.add("d-none");
            getElement("#spinner").classList.remove("d-none");
        }
    }
    getElement("#mcqSearchQuery").addEventListener("click", async () => {
        await mcqExecuteQuery();
    });
    getElement("#mcqQuery").addEventListener("keyup", async (e) => {
        if (e.keyCode == 13) {
            await mcqExecuteQuery();
        }
    });
</script>