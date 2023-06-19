const form = document.querySelector('#projetosForm')
const NomeInput = document.querySelector('#NomeInput')
const ClienteInput = document.querySelector('#ClienteInput')
const DataInput = document.querySelector('#DataInput')
const StatusInput = document.querySelector('#StatusInput')
const tableBody = document.querySelector('#TabelaProjetos tbody')

const URL = 'http://localhost:8080/projetos.php'

function carregarprojetos() {
    fetch(URL, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        },
        mode: 'cors'
    })
    .then(response => response.json())
    .then(projetos => {
        tableBody.innerHTML =''

        projetos.forEach(projetos => {
            const tr = document.createElement('tr')
            tr.innerHTML = `
                <td>${projetos.id}</td>
                <td>${projetos.Nome}</td>
                <td>${projetos.Cliente}</td>
                <td>${projetos.Data}</td>
                <td>${projetos.Status}</td>
                <td>
                    <button data-id="${projetos.id}" onclick="atualizarprojetos(${projetos.id})">Editar</button>
                    <button onclick="excluirprojetos(${projetos.id})">Excluir</button>
                </td>
            `

            tableBody.appendChild(tr)
        })
    })

    
}
function adicionarprojetos(event) {
        event.preventDefault()
        
        const Nome = NomeInput.value
        const Cliente = ClienteInput.value
        const Data = DataInput.value
        const Status = StatusInput.value

        fetch(URL, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `Nome=${encodeURIComponent(Nome)}&Cliente=${encodeURIComponent(Cliente)}&Data${encodeURIComponent(Data)}&Status${Status}`
        })
        .then (response => {
            if (response.ok) {
                carregarprojetos()
                NomeInput.value = ''
                ClienteInput.value = ''
                DataInput.value = ''
                StatusInput.value = ''
            } else {
                console.error('Erro ao adicionar projetos')
                alert('Erro ao adicionar projetos')
            }
        })
}
//excluir projetos

function excluirprojetos(id){
    if(confirm('Deseja excluir esse projetos? ')){
        fetch(`${URL}?id=${id}`,{            
        })
        .then(response =>{
            if (response.ok){
                carregarprojetos()
            }else{
                console.error('Erro ao excluir projetos')
                alert('Erro ao projetos')
            }
        })
    }
}
function atualizarprojetos(id){
    const novoNome = prompt ('Digite um novo nome: ')
    const novoCliente = prompt ('Digite um novo Cliente: ')
    const novoData = prompt ('Digite o novo ano de Data: ')
    const novoStatus= prompt ('Digite o novo status: ')
    if (novoNome && novoCliente && novoData && novoStatus) {
        fetch(`${URL}?id=${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `Nome=${encodedURIComponent(novoNome)}&Cliente=${encodedURIComponent(novoCliente)}&Data=${encodeURIComponent(novoData)}&Status${novoStatus}`
        })
        .then (response => {
            if (response.ok) {
                carregarprojetos()
            } else {
                console.error('Erro ao adicionar o projetos!')
                alert('Erro ao adicionar o projetos!')
            }
        })
    }
}
form.addEventListener('submit', adicionarprojetos)
carregarprojetos()