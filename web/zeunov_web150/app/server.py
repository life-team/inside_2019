from flask import Flask, render_template, request, session, Response
from pickle import loads, dumps
from base64 import b64decode, b64encode
import logging

logging.basicConfig(filename="site.log", level=logging.INFO)

app = Flask(__name__)
app.config['SECRET_KEY'] = '4r3_y0u_u53d_v3ry_53cr37_k3y?'
logging.info(app.config)

@app.route('/', methods=["GET", "POST"])
def index():
    print(session)

    if not session:
        session['username'] = "user"
        session['password']= 'password'

    if request.method == 'POST':
        username = request.form["username"]
        password = request.form["password"]
        session['username'] = username
        session['password'] = password

        if username == 'Admin':
            return(render_template("index.html",message = "Hmmm, you are not Admin!", message1="Admin is watching for you >:(", user="Hacker"))
        elif username == "Obamka":
            return(render_template("index.html", message = "Egorka ne proidet", user= "Egorka"))

    if request.method == "GET":
        if session['username'] == 'Admin' and session['password'] == 'v3ry_53cr37_p455w0rd':
            return render_template("index.html",message="Ooooo, Admin back!", message1='flag{J3st_D0_4t}', user=session['username'])
    return(render_template("index.html", message = "Hmmm, you are not Admin!", message1="Maybe you need register?", user=session['username']))

@app.route('/robots.txt')
def robots():
    f = open('robots.txt', 'r').readlines()
    return Response(f, mimetype='text/plain')

@app.route('/site.log')
def log():
    f = open('site.log', 'r').readlines()
    return Response(f, mimetype='text/plain')

if __name__ == '__main__':
    app.run(port=8081, host='0.0.0.0', debug=False, threaded=True)
