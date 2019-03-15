var express = require('express');
var router = express.Router();
var virus = require('../data/viruses.json');

/* GET home page. */
router.get('/', function(req, res, next) {
    res.render('viruses', {viruses: virus});
});

module.exports = router;
