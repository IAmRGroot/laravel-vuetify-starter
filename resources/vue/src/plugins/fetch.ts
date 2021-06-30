const default_init = {
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    },
    credentials: 'include',
} as RequestInit

const prefix = import.meta.env.VITE_APP_URL;

const getUrl = (url: string): string => {
    return url.startsWith('/') ? prefix + url : url;
};

export const get = async <T>(url: string, init: RequestInit = {}): Promise<T> => {
    return handleResponse<T>(
        await fetch(getUrl(url), {
            method: 'GET',
            ...default_init,
            ...init
        })
    );
}

export const post = async <T>(url: string, body: unknown = {}, init: RequestInit = {}): Promise<T> => {
    return handleResponse<T>(
        await fetch(getUrl(url), {
            method: 'POST',
            body: JSON.stringify(body),
            ...default_init,
            ...init
        })
    );
}

export const put = async <T>(url: string, body: unknown, init: RequestInit = {}): Promise<T> => {
    return handleResponse<T>(
        await fetch(getUrl(url), {
            method: 'PUT',
            body: JSON.stringify(body),
            ...default_init,
            ...init
        })
    );
}

export const _delete = async <T>(url: string, init: RequestInit = {}): Promise<T> => {
    return handleResponse<T>(
        await fetch(getUrl(url), {
            method: 'DELETE',
            ...default_init,
            ...init
        })
    );
}

async function handleResponse<T>(response: Response): Promise<T> {
    let json;

    try {
        json = await response.json();
    } catch (error) {
        json = {};
    }

    if (!response.ok) {
        const error = (json && json.message) || response.statusText;

        return Promise.reject(error);
    }

    return json as T;
}
