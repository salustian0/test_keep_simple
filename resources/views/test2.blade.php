<!doctype html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test 2</title>
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

        #btnSearch, #txtGitHubUserName{
            width: 280px;
            padding: 8px;
            margin: 16px auto;
        }

        .menu{
            padding: 20px;
            display: flex;
            list-style: none;
        }

        .menu li{
            margin-right: 16px;
        }

    </style>
</head>
<body>
<ul class="menu">
    <li>
        <a href="{{url('/test1')}}">Teste 1</a>
    </li>
    <li>
        <a href="{{url('/test3')}}">Teste 3</a>
    </li>
</ul>

<div class="container">
    <h1>Teste 2 - Cliente para consumo da api do github</h1>
    <p>Todo o código utilizado nesse teste foi feito sem a utilização de frameworks ou bibliotecas de chamada de api!<br></p>

    <input type="text" id="txtGitHubUserName" placeholder="Nome de usuario, ex: salustian0">
    <button  id="btnSearch">Buscar</button>

    <div class="git-info mt-16 d-none">
        <div class="top">
            <div class="img-container">
                <img id="img-avatar" src="" alt="user-avatar"/>
            </div>
            <a target="_blank" id="link-perfil" href="">Ver perfil</a>
            <ul  class="mt-16" id="user-info-container"></ul>
        </div>
    </div>

</div>

<script>
    window.onload = () => {

        const btnSearch = document.querySelector('#btnSearch');
        const txtGitHubUsername = document.querySelector('#txtGitHubUserName');
        const imgAvatar = document.querySelector('#img-avatar');
        const userInfoContainer = document.querySelector('#user-info-container')
        const linkPerfil = document.querySelector('#link-perfil')
        const gitInfo = document.querySelector('.git-info')

        btnSearch.addEventListener('click', () => {
            const githubUsername = txtGitHubUsername.value;
            gitInfo.classList.add('d-none')

            if(githubUsername.trim() === ''){
                alert('é necessário informar um usuario para realizar a busca!')
                return;
            }


            requestUserGitHub(githubUsername)
        })

        async function requestUserGitHub(username){
            const url = `https://api.github.com/users/${username}`
            const response = await fetch(url);
            const data = await response.json();

            const { avatar_url, followers = 0, following = 0, type, company , id, name, html_url} = data;

            linkPerfil.href = html_url;
            imgAvatar.src = avatar_url;

            if(response.ok && data){

                const html = `
                <li><div class="label">Id:</div><div class="value">${id || '-'}</div></li>
                <li><div class="label">Nome:</div><div class="value">${name || '-'}</div></li>
                <li><div class="label">Tipo:</div><div class="value">${type || '-'}</div></li>
                <li><div class="label">Seguidores:</div><div class="value">${followers || '-'}</div></li>
                <li><div class="label">Seguindo:</div><div class="value">${following || '-'}</div></li>
                `;
                userInfoContainer.innerHTML = html;
                gitInfo.classList.remove('d-none')
                return;
            }

            alert('Usuário não encontrado!')
        }

    }
</script>
</body>
</html>
