db.createUser({
    user: "bibliotecario",
    pwd: "library-mongo21112023-master",
    roles: [
        { role: "readWrite", db: "Biblioteca" },
        { role: "readWrite", db: "Biblioteca", collection: "" }
    ]
});
