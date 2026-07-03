<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>SenacTUR - Viagens</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; margin: 0; background-color: #f2f2f2; color: #333; }
        header { background-color: #003580; padding: 20px; color: #ffffff; display: flex; justify-content: space-between; align-items: center; }
        header h1 { margin: 0; font-size: 24px; }
        nav button { background: none; border: 1px solid #ffffff; color: #ffffff; padding: 8px 16px; cursor: pointer; border-radius: 4px; }
        .hero { background-color: #003580; padding: 40px 20px 60px; color: #ffffff; text-align: center; }
        .search-container { background: #febb02; padding: 20px; border-radius: 8px; max-width: 1000px; margin: -40px auto 20px; display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
        .search-group { position: relative; flex: 1; min-width: 150px; }
        input[type="text"], input[type="date"] { width: 100%; padding: 12px; border: none; border-radius: 4px; box-sizing: border-box; }
        .passenger-controls { display: flex; align-items: center; gap: 5px; background: #ffffff; padding: 10px; border-radius: 4px; width: 140px; box-sizing: border-box; justify-content: space-between; }
        .btn-qty { background: #003580; color: #ffffff; border: none; width: 30px; height: 30px; border-radius: 4px; cursor: pointer; }
        .btn-qty:disabled { background: #ccc; }
        #btn-buscar-voos { background-color: #003580; color: #ffffff; border: none; padding: 12px 24px; font-size: 16px; font-weight: bold; border-radius: 4px; cursor: pointer; }
        #btn-limpar-busca { background-color: #ffffff; color: #003580; border: 1px solid #003580; padding: 12px 24px; font-size: 16px; font-weight: bold; border-radius: 4px; cursor: pointer; }
        .autocomplete-list { position: absolute; background: #ffffff; border: 1px solid #ddd; width: 100%; z-index: 1000; max-height: 200px; overflow-y: auto; color: #333; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .autocomplete-list div { padding: 10px; cursor: pointer; border-bottom: 1px solid #eee; }
        .autocomplete-list div:hover { background: #f2f2f2; }
        .main-content { max-width: 1000px; margin: auto; padding: 20px; }
        .card { background: #ffffff; padding: 20px; margin-bottom: 15px; border-radius: 8px; border: 1px solid #ddd; display: flex; justify-content: space-between; align-items: center; }
        .card-price { font-size: 24px; font-weight: bold; color: #003580; }
        .btn-comprar { background-color: #febb02; color: #003580; border: none; padding: 10px 20px; font-weight: bold; border-radius: 4px; cursor: pointer; }
        .modal { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center; z-index: 2000; }
        .hidden { display: none !important; }
        .modal-content { background: #ffffff; padding: 30px; border-radius: 8px; width: 450px; text-align: center; }
        .modal-details { margin: 15px 0; text-align: left; }
        .btn-confirmar { background: #003580; color: #ffffff; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; margin: 5px; }
        .btn-cancelar { background: #ccc; color: #333; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; margin: 5px; }
        .flight-info { background: #f9f9f9; padding: 15px; border-radius: 4px; border: 1px solid #eee; margin-bottom: 10px; }
        .flight-info p { margin: 5px 0; }
        .flight-price { color: #003580; font-weight: bold; font-size: 16px; margin-top: 10px !important; }
        .mt-2 { margin-top: 10px; }
        h3 i { color: #003580; margin: 0 10px; }
    </style>
</head>
<body>
    <header>
        <h1>SenacTUR</h1>
        <nav>
            <button id="btn-nav-reservas" onclick="carregarReservas()"><i class="fa-solid fa-suitcase-rolling"></i> Minhas Reservas</button>
            <button id="btn-nav-home" onclick="mostrarHome()"><i class="fa-solid fa-magnifying-glass"></i> Nova Busca</button>
        </nav>
    </header>

    <div id="view-home">
        <div class="hero">
            <h2>Encontre sua próxima viagem</h2>
        </div>
        <div class="search-container">
            <div class="search-group">
                <input type="text" id="input-origem" placeholder="Origem" autocomplete="off">
                <div id="autocomplete-origem" class="autocomplete-list hidden"></div>
            </div>
            <div class="search-group">
                <input type="text" id="input-destino" placeholder="Destino" autocomplete="off">
                <div id="autocomplete-destino" class="autocomplete-list hidden"></div>
            </div>
            <div class="search-group">
                <input type="date" id="input-data-ida">
            </div>
            <div class="search-group">
                <input type="date" id="input-data-volta">
            </div>
            <div class="passenger-controls">
                <span><i class="fa-solid fa-user"></i> Adultos</span>
                <button class="btn-qty" id="btn-menos-adulto">-</button>
                <span id="txt-qtd-adultos">1</span>
                <button class="btn-qty" id="btn-mais-adulto">+</button>
            </div>
            <div class="passenger-controls">
                <span><i class="fa-solid fa-child"></i> Crianças</span>
                <button class="btn-qty" id="btn-menos-crianca">-</button>
                <span id="txt-qtd-criancas">0</span>
                <button class="btn-qty" id="btn-mais-crianca">+</button>
            </div>
            <button id="btn-buscar-voos" onclick="buscarVoos()">Pesquisar</button>
            <button id="btn-limpar-busca" onclick="limparBusca()">Limpar</button>
        </div>

        <div class="main-content" id="container-resultados"></div>
    </div>

    <div id="view-reservas" class="hidden main-content">
        <h2>Minhas Reservas</h2>
        <div id="container-lista-reservas"></div>
    </div>

    <div id="modal-confirmacao" class="modal hidden">
        <div class="modal-content">
            <h3>Confirmar Compra</h3>
            <div id="txt-detalhe-valores" class="modal-details"></div>
            <p id="txt-valor-total" class="card-price"></p>
            <button id="btn-confirmar-compra" class="btn-confirmar" onclick="finalizarCompra()">Confirmar</button>
            <button id="btn-fechar-modal" class="btn-cancelar" onclick="fecharModal()">Cancelar</button>
        </div>
    </div>

    <script>
        const inputOrigem = document.getElementById('input-origem');
        const inputDestino = document.getElementById('input-destino');
        const autoOrigem = document.getElementById('autocomplete-origem');
        const autoDestino = document.getElementById('autocomplete-destino');
        
        let dataAtual = new Date().toISOString().split('T')[0];
        document.getElementById('input-data-ida').setAttribute('min', dataAtual);
        document.getElementById('input-data-volta').setAttribute('min', dataAtual);

        let qtdAdultos = 1;
        let qtdCriancas = 0;
        
        let voosAtuais = [];
        let vooIdaSelecionado = null;
        let vooVoltaSelecionado = null;
        let idAgendamentoEmEdicao = null;
        let etapaBusca = 'ida';
        let reservasAtuais = [];

        document.getElementById('btn-mais-adulto').addEventListener('click', () => updatePassageiros('adultos', 1));
        document.getElementById('btn-menos-adulto').addEventListener('click', () => updatePassageiros('adultos', -1));
        document.getElementById('btn-mais-crianca').addEventListener('click', () => updatePassageiros('criancas', 1));
        document.getElementById('btn-menos-crianca').addEventListener('click', () => updatePassageiros('criancas', -1));

        function updatePassageiros(tipo, valor) {
            let totalAtual = qtdAdultos + qtdCriancas;
            if (tipo === 'adultos') {
                if (valor > 0 && totalAtual < 9) qtdAdultos++;
                if (valor < 0 && qtdAdultos > 1) qtdAdultos--;
                document.getElementById('txt-qtd-adultos').innerText = qtdAdultos;
            } else {
                if (valor > 0 && totalAtual < 9) qtdCriancas++;
                if (valor < 0 && qtdCriancas > 0) qtdCriancas--;
                document.getElementById('txt-qtd-criancas').innerText = qtdCriancas;
            }
        }

        inputOrigem.addEventListener('input', (e) => handleAutocomplete(e.target.value, autoOrigem, inputOrigem));
        inputDestino.addEventListener('input', (e) => handleAutocomplete(e.target.value, autoDestino, inputDestino));

        async function handleAutocomplete(termo, container, inputTarget) {
            if (termo.length < 3) {
                container.classList.add('hidden');
                return;
            }
            const res = await fetch(`index.php?action=autocomplete&termo=${termo}`);
            const locais = await res.json();
            container.innerHTML = '';
            
            if (locais.length > 0) {
                container.classList.remove('hidden');
                locais.forEach(local => {
                    const div = document.createElement('div');
                    div.innerText = local.nome;
                    div.onclick = () => {
                        inputTarget.value = local.nome;
                        container.classList.add('hidden');
                    };
                    container.appendChild(div);
                });
            } else {
                container.classList.add('hidden');
            }
        }

        async function buscarVoos() {
            etapaBusca = 'ida';
            vooIdaSelecionado = null;
            vooVoltaSelecionado = null;
            
            const origem = inputOrigem.value;
            const destino = inputDestino.value;
            const dataIda = document.getElementById('input-data-ida').value;
            
            if (!origem || !destino || !dataIda) {
                alert("Preencha origem, destino e a data de ida.");
                return;
            }
            if (origem === destino) {
                alert("Origem e destino não podem ser iguais.");
                return;
            }

            document.getElementById('container-resultados').innerHTML = '<p><i class="fa-solid fa-spinner fa-spin"></i> Buscando voos de ida...</p>';
            
            const res = await fetch(`index.php?action=pesquisar&origem=${origem}&destino=${destino}&data_ida=${dataIda}`);
            const voos = await res.json();
            
            renderizarVoos(voos);
        }

        function renderizarVoos(voos) {
            voosAtuais = voos;
            const container = document.getElementById('container-resultados');
            container.innerHTML = '';
            
            if (voos.length === 0) {
                container.innerHTML = '<p>Nenhum voo encontrado para esta rota e data.</p>';
                return;
            }

            const tituloEtapa = document.createElement('h3');
            tituloEtapa.innerHTML = etapaBusca === 'ida' ? '<i class="fa-solid fa-plane-departure"></i> Selecione o Voo de Ida' : '<i class="fa-solid fa-plane-arrival"></i> Selecione o Voo de Volta';
            container.appendChild(tituloEtapa);

            voos.forEach((v, index) => {
                const precoBase = parseFloat(v.preco_base);
                const precoAdultos = precoBase * qtdAdultos;
                const precoCriancas = (precoBase * 0.5) * qtdCriancas;
                const total = precoAdultos + precoCriancas;

                const card = document.createElement('div');
                card.className = 'card';
                card.id = `card-voo-${index}`;
                card.innerHTML = `
                    <div>
                        <h3>${v.origem_nome} <i class="fa-solid fa-arrow-right"></i> ${v.destino_nome}</h3>
                        <p><i class="fa-regular fa-calendar"></i> ${v.data_voo} &nbsp;&nbsp; <i class="fa-regular fa-clock"></i> ${v.horario}</p>
                    </div>
                    <div style="text-align: right;">
                        <div class="card-price">R$ ${total.toFixed(2)}</div>
                        <button id="btn-comprar-voo-${index}" class="btn-comprar" onclick="selecionarVoo(${index})">Selecionar</button>
                    </div>
                `;
                container.appendChild(card);
            });
        }

        async function selecionarVoo(index) {
            const voo = voosAtuais[index];
            
            if (etapaBusca === 'ida') {
                vooIdaSelecionado = voo;
                const dataVolta = document.getElementById('input-data-volta').value;
                
                if (dataVolta) {
                    etapaBusca = 'volta';
                    document.getElementById('container-resultados').innerHTML = '<p><i class="fa-solid fa-spinner fa-spin"></i> Buscando voos de volta...</p>';
                    const res = await fetch(`index.php?action=pesquisar&origem=${voo.destino_nome}&destino=${voo.origem_nome}&data_ida=${dataVolta}`);
                    const voosVolta = await res.json();
                    renderizarVoos(voosVolta);
                } else {
                    abrirModalCompra();
                }
            } else {
                vooVoltaSelecionado = voo;
                abrirModalCompra();
            }
        }

        function abrirModalCompra() {
            let valorIdaCalculado = (parseFloat(vooIdaSelecionado.preco_base) * qtdAdultos) + ((parseFloat(vooIdaSelecionado.preco_base) * 0.5) * qtdCriancas);
            
            let detalheValores = `
                <div class="flight-info">
                    <p><strong><i class="fa-solid fa-plane-departure"></i> Ida:</strong> ${vooIdaSelecionado.origem_nome} <i class="fa-solid fa-arrow-right"></i> ${vooIdaSelecionado.destino_nome}</p>
                    <p><i class="fa-regular fa-calendar"></i> ${vooIdaSelecionado.data_voo} &nbsp;&nbsp; <i class="fa-regular fa-clock"></i> ${vooIdaSelecionado.horario}</p>
                    <p class="flight-price">Valor da Ida: R$ ${valorIdaCalculado.toFixed(2)}</p>
                </div>`;
                
            let precoBaseTotal = parseFloat(vooIdaSelecionado.preco_base);
            
            if (vooVoltaSelecionado) {
                let valorVoltaCalculado = (parseFloat(vooVoltaSelecionado.preco_base) * qtdAdultos) + ((parseFloat(vooVoltaSelecionado.preco_base) * 0.5) * qtdCriancas);
                
                detalheValores += `
                <div class="flight-info mt-2">
                    <p><strong><i class="fa-solid fa-plane-arrival"></i> Volta:</strong> ${vooVoltaSelecionado.origem_nome} <i class="fa-solid fa-arrow-right"></i> ${vooVoltaSelecionado.destino_nome}</p>
                    <p><i class="fa-regular fa-calendar"></i> ${vooVoltaSelecionado.data_voo} &nbsp;&nbsp; <i class="fa-regular fa-clock"></i> ${vooVoltaSelecionado.horario}</p>
                    <p class="flight-price">Valor da Volta: R$ ${valorVoltaCalculado.toFixed(2)}</p>
                </div>`;
                
                precoBaseTotal += parseFloat(vooVoltaSelecionado.preco_base);
            }
            
            const totalGeral = (precoBaseTotal * qtdAdultos) + ((precoBaseTotal * 0.5) * qtdCriancas);
            
            document.getElementById('txt-detalhe-valores').innerHTML = detalheValores;
            document.getElementById('txt-valor-total').innerText = `Total Final: R$ ${totalGeral.toFixed(2)}`;
            document.getElementById('modal-confirmacao').classList.remove('hidden');
        }

        function fecharModal() {
            document.getElementById('modal-confirmacao').classList.add('hidden');
        }

        async function finalizarCompra() {
            let precoBaseTotal = parseFloat(vooIdaSelecionado.preco_base);
            if (vooVoltaSelecionado) {
                precoBaseTotal += parseFloat(vooVoltaSelecionado.preco_base);
            }
            const totalGeral = (precoBaseTotal * qtdAdultos) + ((precoBaseTotal * 0.5) * qtdCriancas);

            const payload = {
                id_reserva: idAgendamentoEmEdicao,
                voo_ida_detalhes: vooIdaSelecionado,
                voo_volta_detalhes: vooVoltaSelecionado,
                adultos: qtdAdultos,
                criancas: qtdCriancas,
                total: totalGeral.toFixed(2)
            };

            const url = idAgendamentoEmEdicao ? 'index.php?action=atualizar_reserva' : 'index.php?action=reservar';

            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });

                const resposta = await res.json();
                
                if (resposta.erro) {
                    alert("Erro no backend: " + resposta.erro);
                    return;
                }

                if (resposta.sucesso) {
                    fecharModal();
                    idAgendamentoEmEdicao = null;
                    carregarReservas();
                }
            } catch (error) {
                alert("Falha na requisição.");
            }
        }

        async function carregarReservas() {
            document.getElementById('view-home').classList.add('hidden');
            document.getElementById('view-reservas').classList.remove('hidden');
            
            const res = await fetch('index.php?action=listar_reservas');
            reservasAtuais = await res.json();
            const container = document.getElementById('container-lista-reservas');
            container.innerHTML = '';

            if (reservasAtuais.length === 0) {
                container.innerHTML = '<p>Nenhuma reserva encontrada.</p>';
                return;
            }

            reservasAtuais.forEach((r, idx) => {
                const card = document.createElement('div');
                card.className = 'card';
                card.id = `card-reserva-${r.id}`;
                
                let precoBaseIda = parseFloat(r.preco_base_ida);
                let valorIdaCalculado = (precoBaseIda * parseInt(r.qtd_adultos)) + (precoBaseIda * 0.5 * parseInt(r.qtd_criancas));
                
                let infoVoos = `
                <div class="flight-info">
                    <p><strong><i class="fa-solid fa-plane-departure"></i> Ida:</strong> ${r.origem_ida} <i class="fa-solid fa-arrow-right"></i> ${r.destino_ida}</p>
                    <p><i class="fa-regular fa-calendar"></i> ${r.data_ida} &nbsp;&nbsp; <i class="fa-regular fa-clock"></i> ${r.horario_ida}</p>
                    <p class="flight-price">Valor: R$ ${valorIdaCalculado.toFixed(2)}</p>
                </div>`;
                
                if (r.voo_volta_id) {
                    let precoBaseVolta = parseFloat(r.preco_base_volta);
                    let valorVoltaCalculado = (precoBaseVolta * parseInt(r.qtd_adultos)) + (precoBaseVolta * 0.5 * parseInt(r.qtd_criancas));
                    
                    infoVoos += `
                    <div class="flight-info mt-2">
                        <p><strong><i class="fa-solid fa-plane-arrival"></i> Volta:</strong> ${r.origem_volta} <i class="fa-solid fa-arrow-right"></i> ${r.destino_volta}</p>
                        <p><i class="fa-regular fa-calendar"></i> ${r.data_volta} &nbsp;&nbsp; <i class="fa-regular fa-clock"></i> ${r.horario_volta}</p>
                        <p class="flight-price">Valor: R$ ${valorVoltaCalculado.toFixed(2)}</p>
                    </div>`;
                }

                card.innerHTML = `
                    <div style="flex: 1; padding-right: 20px;">
                        <h3>Reserva #${r.id} - ${r.status}</h3>
                        ${infoVoos}
                        <p><i class="fa-solid fa-user"></i> Adultos: ${r.qtd_adultos} &nbsp;&nbsp; <i class="fa-solid fa-child"></i> Crianças: ${r.qtd_criancas}</p>
                    </div>
                    <div style="text-align: right; min-width: 200px;">
                        <div class="card-price">Total Final: R$ ${r.valor_total}</div>
                        <br>
                        ${r.status === 'Confirmada' ? `
                            <button id="btn-editar-reserva-${r.id}" class="btn-confirmar" onclick="prepararEdicao(${idx})">Editar Reserva</button>
                            <button id="btn-cancelar-reserva-${r.id}" class="btn-cancelar" onclick="cancelarReserva(${r.id})">Cancelar Reserva</button>
                        ` : ''}
                    </div>
                `;
                container.appendChild(card);
            });
        }

        function prepararEdicao(idx) {
            const r = reservasAtuais[idx];
            idAgendamentoEmEdicao = r.id;
            inputOrigem.value = r.origem_ida;
            inputDestino.value = r.destino_ida;
            document.getElementById('input-data-ida').value = r.data_ida;
            document.getElementById('input-data-volta').value = r.data_volta || '';
            qtdAdultos = parseInt(r.qtd_adultos);
            qtdCriancas = parseInt(r.qtd_criancas);
            document.getElementById('txt-qtd-adultos').innerText = qtdAdultos;
            document.getElementById('txt-qtd-criancas').innerText = qtdCriancas;
            mostrarHome();
            buscarVoos();
        }

        async function cancelarReserva(id) {
            const res = await fetch('index.php?action=cancelar_reserva', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id })
            });
            const resposta = await res.json();
            if (resposta.sucesso) {
                carregarReservas();
            }
        }

        function limparBusca() {
            inputOrigem.value = '';
            inputDestino.value = '';
            document.getElementById('input-data-ida').value = '';
            document.getElementById('input-data-volta').value = '';
            qtdAdultos = 1;
            qtdCriancas = 0;
            document.getElementById('txt-qtd-adultos').innerText = '1';
            document.getElementById('txt-qtd-criancas').innerText = '0';
            document.getElementById('container-resultados').innerHTML = '';
            voosAtuais = [];
            vooIdaSelecionado = null;
            vooVoltaSelecionado = null;
            idAgendamentoEmEdicao = null;
            etapaBusca = 'ida';
            autoOrigem.classList.add('hidden');
            autoDestino.classList.add('hidden');
        }

        function mostrarHome() {
            document.getElementById('view-reservas').classList.add('hidden');
            document.getElementById('view-home').classList.remove('hidden');
            if (!idAgendamentoEmEdicao) {
                limparBusca();
            }
        }
    </script>
</body>
</html>