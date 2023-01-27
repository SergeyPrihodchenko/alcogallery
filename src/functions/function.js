export const authSend = async (name, password) => {
    const data = {
        nickName: name,
        pass: password
    }
    const response = await fetch('./backEnd/index.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'aplication/json',
            'ACTION': 'AUTHENTICATION'
        },
        body: JSON.stringify(data)
    });

    const result = await response.json();
    if(result['success'] === true) {
        document.location.reload();
    }
    
    return result;
}

export function getCoockie(name) {
    const strCookie = document.cookie;
    
    const arrCoockie = strCookie.split(';');
    let assocCookie = [];
    arrCoockie.forEach(el => {
        const cookie = el.split('=');

        if(cookie[0] !== '') {
            cookie[0] = cookie[0].trim();
            cookie[1] = cookie[1].trim();
            assocCookie[cookie[0]] = cookie[1];
        }
    });

    if(assocCookie[name] === undefined) {
        return false;
    } else {
        return assocCookie[name];
    }
}