const Ziggy = {
    url: 'http://localhost:8000',
    appUrl: 'http://localhost:8000/',
    port: null,
    defaults: {},
    routes: {
        'register': { uri: 'register', methods: ['GET'] },
        'login': { uri: 'login', methods: ['GET'] },
        'home': { uri: '/', methods: ['GET'] },
        'profile.show': { uri: 'profile/{user}', methods: ['GET'], parameters: ['user'] },
        'profile.edit': { uri: 'profile/edit', methods: ['GET'] },
        'profile.update': { uri: 'profile', methods: ['PUT'] },
        'profile.avatar.upload': { uri: 'profile/avatar', methods: ['POST'] },
        'profile.avatar.delete': { uri: 'profile/avatar', methods: ['DELETE'] },
        'logout': { uri: 'logout', methods: ['POST'] },
    },
};

export { Ziggy };
