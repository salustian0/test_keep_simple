<!doctype html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Test 3</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body{
            font-family: sans-serif;

        }
        #json-content{
            margin-top: 24px;
            color: #368436;
        }

        h1{
            font-size: 16px;
        }
        .container{
            padding: 20px;
            display: flex;
            width: 1080px;
            height: auto;
            flex-direction: column;
            margin: 20px auto;
            background-color: #ecedee;
        }

        p{
            margin-top: 16px;
            color: #507cc5;
        }
        .bold{
            font-weight: 600;
        }

        .git-info{
            margin: auto;
            width: 500px;
            background-color: #ffff;
            border-radius: 4px;
            box-shadow: 2px 2px 5px 1px rgba(0,0,0,.4) ;
            padding: 16px;
        }

        .git-info .top{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }


        .git-info .img-container img{
            border-radius: 50%;
            height: 148px;
            width: 148px;
            border: 1px solid rgba(0,0,0,.5);
        }

        .git-info ul {
            list-style: none;
        }

        .mt-16{
            margin-top: 16px;
        }

        #user-info-container{
            display: flex;
            flex-direction: column;
        }

        #user-info-container li{
            margin-top: 15px;
            display: flex;
            justify-content: space-between;
            width: 200px;
        }

        #user-info-container li .label{
            font-weight: 600;
            font-size: 16px;
            color: #343438;
            margin-right: 16px  ;
        }

        #user-info-container li .value{
            font-size: 16px;
            color: #8d8d93;
        }

        #link-perfil{
            padding: 8px;
            width: 200px;
            text-decoration: none;
            display: flex;
            justify-content: center;
            border-radius: 4px;
            background-color: #8d8d93;
            color: #fff;
            margin: 16px 0 ;
        }

        #link-perfil:hover{
            color: #000;
        }

        .d-none{
            display: none !important;
        }

        #btnSearch, #txtCep, #btnClear, #btnExportCsv{
            width: 280px;
            padding: 8px;
            margin: 16px auto;
        }

    </style>
</head>
<body>

<div class="container">
    <h1>Teste 3 - Cliente para consumo da api viacep com possibilidade de buscar por diferentes ceps</h1>
    <p>Todo o código utilizado nesse teste foi feito sem a utilização de frameworks ou bibliotecas de chamada de api!<br></p>

    <input type="text" id="txtCep" placeholder="Cep, ex: 07808110">
    <button  id="btnSearch">Buscar</button>
    <button  id="btnClear">Limpar</button>
    <button  id="btnExportCsv">Exportar em CSV</button>

    <table id="table-ceps" border="1">
        <thead>
        <tr>
            <th>Cep</th>
            <th>Bairro</th>
            <th>Logradouro</th>
            <th>Localidade</th>
            <th>UF</th>
        </tr>
        </thead>
        <tbody>
        <tr id="no-data"><td colspan="5">Sem dados ...</td></tr>
        </tbody>
    </table>

</div>

<script>
    window.onload = () => {

        let listOfCeps = [];

        const btnSearch = document.querySelector('#btnSearch');
        const txtCep = document.querySelector('#txtCep');
        const btnClear = document.querySelector('#btnClear')
        const btnExport = document.querySelector('#btnExportCsv')
        const tableCeps = document.querySelector('#table-ceps')
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let loading = false;


        btnExport.addEventListener('click', () => {
            requestExportCsv()
        })

        /**
         * exporta ceps em csv
         * @returns {Promise<void>}
         */
        async function requestExportCsv(){
            if(listOfCeps.length > 0){

                const url = @json(route('export_csv'));
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({dataToExport: listOfCeps})
                })

                if(response.ok){
                    const blob = await response.blob();
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.download = 'ceps.csv';
                    link.click();
                }

                return;
            }
            alert('É necessário adicionar ao menos um cep para a exportação')
        }

        btnClear.addEventListener('click', () => {
            tableCeps.querySelector('tbody').innerHTML = `<tr id="no-data"><td colspan="5">Sem dados ...</td></tr>`;
            listOfCeps = [];
        })

        btnSearch.addEventListener('click', () => {
            const cep = txtCep.value;

            if(loading === true) return;

            if(cep.trim() === ''){
                alert('é necessário informar um cep para realizar a busca!')
                return;
            }

            requestViaCep(cep)
        })

        async function requestViaCep(cep){
            try{

                loading = true;
                /**
                 * Validação de cep ja consultado
                 */
                if(listOfCeps.length > 0){
                    const exists = listOfCeps.find(obj => obj.cep.replace('-', '') == cep)
                    if(exists){
                        alert('Cep já consultado!')
                        loading = false;
                        return;
                    }
                }

                const url = `https://viacep.com.br/ws/${cep}/json/`
                const response = await fetch(url);
                const data = await response.json();

                if(response.ok && data){

                    const { cep: cepFormaatado, bairro, ddd, localidade, logradouro, uf, erro} = data;

                    if(erro === true){
                        throw new Error('Cpf inválido');
                    }

                    listOfCeps.push(data)

                    const noData = tableCeps.querySelector('tbody tr#no-data');
                    if(noData){
                        const noDataParent = noData.parentNode
                        noDataParent.removeChild(noData)
                    }

                    const html = `<tr>
                                        <td>${cepFormaatado}</td>
                                        <td>${bairro}</td>
                                        <td>${logradouro}</td>
                                        <td>${localidade}</td>
                                        <td>${uf}</td>
                                    </tr>`;

                    tableCeps.querySelector('tbody').innerHTML += html
                    loading = false;
                    return;
                }
                throw new Error('Cep inválido');
            }catch (ex){
                alert('Cep inválido!')
                loading = false;
            }
        }

    }
</script>
</body>
</html>
