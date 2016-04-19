<div class="Body" ng-controller="LoginForm">
    <div class="message">
        <h3>Welcoom <span>@{{message}}</span></h3>
    </div>
    <div class="form">
        <div class="inputGroupe">
            <label for="username"><i class="fa fa-user"></i></label>
            <input type="email" ng-model="cridentiel.email" placeholder="User Name">
        </div>

        <div class="inputGroupe">
            <label for="password"><i class="fa fa-unlock-alt"></i></label>
            <input type="password" ng-model="cridentiel.password" placeholder="Pass Word">
        </div>

        <div class="Button">
            <button ng-click="Login()" class="btn LoginBTN" type="button" name="Login">Login</button>
        </div>

    </div>
</div>