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

export const sendFileData = async (files, valueName, valueDescription) => {
    const formData = new FormData();
        formData.append('img_file', files);

        const data = {
            name: valueName,
            description: valueDescription,
            img_name: files.name
        }
        
        const response = await fetch('./backEnd/index.php', {
            method: 'POST',
            headers: {
                'ACTION': 'SAVE_IMG_FILE'
            },
            body: formData
        })

        let result = await response.json();

        if(result.success) {

            
            const response = await fetch('./backEnd/index.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'aplication/json',
                    'ACTION': 'SAVE_CONTENT_DATA'
                },
                body: JSON.stringify(data)
            });

            return await response.json();
        }
}