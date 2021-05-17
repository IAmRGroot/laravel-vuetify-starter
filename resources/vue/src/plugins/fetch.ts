const default_headers = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
};
const prefix = 'http://laravel.docker';

const getUrl = (url: string): string => {
    return url.startsWith('/') ? prefix + url : url;
};

export const get = async <T>(url: string, init: RequestInit = {}): Promise<T> => {
    return handleResponse<T>(
        await fetch(getUrl(url), {
            method: 'GET',
            headers: default_headers,
            ...init
        })
    );
}

export const post = async <T>(url: string, body: any, init: RequestInit = {}): Promise<T> => {
    return handleResponse<T>(
        await fetch(getUrl(url), {
            method: 'POST',
            headers: default_headers,
            body: JSON.stringify(body),
            ...init
        })
    );
}

export const put = async <T>(url: string, body: any, init: RequestInit = {}): Promise<T> => {
    return handleResponse<T>(
        await fetch(getUrl(url), {
            method: 'PUT',
            headers: default_headers,
            body: JSON.stringify(body),
            ...init
        })
    );
}

export const _delete = async <T>(url: string, init: RequestInit = {}): Promise<T> => {
    return handleResponse<T>(
        await fetch(getUrl(url), {
            method: 'DELETE',
            headers: default_headers,
            ...init
        })
    );
}

async function handleResponse<T>(response: Response): Promise<T> {
    const json = await response.json();

    if (!response.ok) {
        const error = (json && json.message) || response.statusText;

        return Promise.reject(error);
    }

    return json as T;
}
