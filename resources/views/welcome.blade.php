<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Agenda</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="/criar-contato">Criar Contato</a>
                        <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Sair') }}
                                    </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        

                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Criar Usuario</a>
                        @endif
                    @endauth
                </div>
            @endif
        @if(Route::has('register'))
        <div class="content">
            <div class="title m-b-md">
                AGENDA
            </div>
            @auth


            <form action="/buscar" method="GET">
                <div class="form-group row">
                    <label for="">Buscar por</label>
                    <select class="form-control" name="tipo" id="">
                        <option value="nome">Nome</option>
                        <option value="telefone">Telefone</option>
                    </select>
                    <input type="text" id="search" name="search" class="form-control" placeholder="Buscar">
                    
                    <button>Buscar</button>
                </div>
            </form>


            
            @if(count($contatos) == 0)
            <br>
            <div>Nenhum contato encontrado</div>
            
            @elseif($contatos)
            <table class="table">
                    <h1>Lista de Contatos</h1>
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                        <th scope="col">Sobrenome</th>
                    </tr>
                    </thead>
                    <tbody>
                            @foreach($contatos as $contato)
                                <tr>
                                    <td style="text-align:left;">{{$contato->nome}}</td>
                                    <td style="text-align:left;">{{$contato->sobrenome}}</td>
                                    <td>
                                        <a href="/mostrar-telefones/{{ $contato->id }}">Ver telefones</a></td>
                                    <td>
                                        <a href="/editar-contato/{{ $contato->id }}">Editar</a>
                                    </td>
                                    <td>
                                        <a href="/excluir-contato/{{ $contato->id }}">Excluir</a>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                </table>
                @endif
                @endauth
            </div>
        </div>
    </body>
</html>
