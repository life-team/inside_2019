var express = require('express');
var router = express.Router();
const _ = require('lodash');

/* GET users listing. */
router.get('/', function(req, res, next) {
    let viruse = require('../data/viruses.json'); // костыль чтобы
  res.send(viruse);
});

router.put('/disinfection/', function(req, res, next) {
    let viruses = require('../data/viruses.json');
    let rBody = req.body
    viruses.forEach((virus) => {
        _.merge(virus, rBody)
        })
    delete viruses[0].pollution;
    if(viruses[0].codename == "Зеленая Отрава" && viruses[0].pollution == false){
        res.send('CTF{GR33N_P0ISI0N_WILL_B3_FUCK3D}');
    }
    else { viruses[0].pollution = true; res.send(viruses);}
    viruses[0].pollution = true;
});

module.exports = router;
