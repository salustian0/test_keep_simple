<!doctype html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test 1</title>
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
    </style>
</head>
<body>

    <div class="container">
        <h1>Teste 1 - Realizando uma chamada de api com fetch api para a api pública viacep</h1>
        <p>Todo o código utilizado nesse teste foi feito sem a utilização de frameworks ou bibliotecas de chamada de api!<br>
            Esse teste basicamente realiza uma chamada de api para a api pública viacep passando o cep: <span class="bold">07726635</span><br>
            que é fixado no código, utilizando fetch api do javascript, o css nessa tela é simples e desenvolvido sem a utilização de frameworks de estilização
        </p>
        <pre id="json-content"></pre>
    </div>

<script>
    window.onload = () => {

        async function requestViaCepApi(){
            const cep = `07726635`
            const url = `https://viacep.com.br/ws/${cep}/json/`
            const response = await fetch(url);
            const data = await response.json();
            document.querySelector('#json-content').innerHTML = JSON.stringify(data, null, 2);
        }

        requestViaCepApi()

    }
</script>
</body>
</html>
