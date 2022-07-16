async function getSocks() {
    let res = await fetch('http://socks.api/api/socks', {
        method: 'GET'
    });

    const data = await res.json();
    console.log(data);

    const wrapper = document.querySelector('.socks-cards');
    wrapper.innerHTML = ``;

    data.forEach((sock) => {
        wrapper.innerHTML += `
        <div class="card-body">
            <ul>
                <li>Штрихкод: ${sock.barCode}</li>
                <li>Название: ${sock.name}</li>
                <li>Цвет: ${sock.color}</li>
                <li>Процент хлопка: ${sock.cotton_part}</li>
                <li>Количество: ${sock.quantity}</li>
            </ul>
        </div>
    `;
    })

}

const getAll  = document.querySelector('#getAll');
getAll.addEventListener('click', (e) => {
    e.preventDefault();
    getSocks();
});


async function incomeSocks() {
    const form = document.querySelector('#incomeSocks');
    const formData = new FormData(form);

    const res = await fetch('http://socks.api/api/socks/income', {
        method: 'POST',
        body: formData
    });

    const data = await res.json();

    if (data.status === true) {
        form.reset();
        alert(data.message);
    } else {
        alert('Произошлка ошибка');
    }

}

const income = document.querySelector('#income');
income.addEventListener('click', (e) => {
    e.preventDefault();
    incomeSocks();
})


async function outcomeSocks() {
    const form = document.querySelector('#outcomeSocks');
    const formData = new FormData(form);

    const res = await fetch('http://socks.api/api/socks/outcome', {
        method: 'POST',
        body: formData
    });

    const data = await res.json();

    if (data.status === true) {
        form.reset();
        alert(data.message);
    } else {
        alert('Произошлка ошибка');
    }

}

const outcome = document.querySelector('#outcome');
outcome.addEventListener('click', (e) => {
    e.preventDefault();
    outcomeSocks();
})


