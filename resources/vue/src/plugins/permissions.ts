type PermissionSetup = Record<string, string[]>;
type AuthSetup = RegExp[];

const permissions: PermissionSetup = { maintenance: ['maintenance'] };

const public_routes: AuthSetup = [
    /^\/login$/,
];

export const isPublic = (path: string): boolean => public_routes.some(public_route => public_route.test(path));

export const getPermissions = (name: string): string[] => {
    if (!(name in permissions)) {
        return [];
    }

    return permissions[name];
};