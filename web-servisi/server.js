var express = require('express');
var app = express();

//const dbConfig = require("./db.config.js");
var mysql = require('mysql');

var bodyParser = require('body-parser');
app.use(bodyParser.urlencoded({extended: false}));
app.use(bodyParser.json());

var dbConn = mysql.createConnection({
    host: "ucka.veleri.hr",
    user: "lprodan",
    password: "11",
    database: "lprodan"
    });
    
    dbConn.connect(); 

app.get("/podaci", function(request, response){
    return response.send({message:"ok"});
})
app.get("/podaci/:id", function(request, response){
    var id = request.params.id;
    return response.send({message: id+"ok"});
})
app.post("/podaci", function(request, response){
    var podaci = request.body.podatak;
    return response.send({message: podaci+" ok"});
})
app.post("/tenisice", function(request, response){
    var marka = request.body.marka;
    var ime = request.body.ime;
    var velicina = request.body.velicina;
    var cijena = request.body.cijena;
    //return response.send({message: ime+" "+prezime+" ok"});

    dbConn.query('INSERT INTO tenisice VALUES (NULL,?,?,?,?)', [marka, ime, velicina, cijena], function(error, results, fields) {
        if (error) throw error;
        return response.send({ error: false, data: results, message:'INSERT korisnik ime = '+ime });
    })
})
app.put("/tenisice/:id", function(request, response){
    var id_tenisica = request.params.id_tenisica;
    var marka = request.body.marka;
    var ime = request.body.ime;
    var velicina = request.body.velicina;
    var cijena = request.body.cijena;
    //return response.send({message: "UPDATE "+id+" nova adresa: "+adresa});

    dbConn.query('UPDATE tenisice SET marka=?, ime=?, velicina=?, cijena=? WHERE id=?', [marka, ime, velicina, cijena, id_tenisica], function(error, results, fields) {
        if (error) throw error;
        return response.send({ error: false, data: results, message:'UPDATE korisnik ime = '+ime });
    })
})
app.delete("/tenisice/:id", function(request, response){
    var id = request.params.id;

    dbConn.query('DELETE FROM tenisice where id=?', id_tenisica, function(error, results, fields) {
        if (error) throw error;
        return response.send({ error: false, data: results[0], message:'DELETE korisnik id='+id });
    })
    //return response.send({message: "DELETE "+id});
})
app.get("/tenisice", function(request, response){
    //return response.send({message:"READ korisnik"});
    dbConn.query('SELECT * FROM tenisice', function (error, results, fields) {
        if (error) throw error;
        return response.send({ error: false, data: results, message: 'READ svi korisnici' });
    })
})

app.get("/tenisice/:id", function(request, response){
    //var id = request.params.id;
    //return response.send({message: "READ korisnik "+id});

    let id_tenisica = request.params.id_tenisica;
    if (!id_tenisica) {
    return response.status(400).send({ error: true, message: 'id' });
    }
    dbConn.query('SELECT * FROM tenisice where id=?', id_tenisica, function(error, results, fields) {
    if (error) throw error;
    return response.send({ error: false, data: results[0], message:'korisnik' });
});

})
// set port
app.listen(3000, function () {
    console.log('Node app is running on port 3000');
})
