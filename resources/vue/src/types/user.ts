export type LoginResponse = {
    url: string;
};

export type User = {
    id: number,
    name: string,
    permissions: string[],
};