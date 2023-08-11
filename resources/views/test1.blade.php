<!doctype html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test 1</title>
</head>
<body>
    <h1>Teste 1 - Realizando uma chamada de api com fetch api para a api pública viacep</h1>

<script>
    window.onload = () => {

        async function requestViaCepApi(){
            const cep = `07726635`
            const url = `https://viacep.com.br/ws/${cep}/json/`
            const data = await fetch(url);
            console.log(data)
        }

    }
</script>
</body>
</html>
