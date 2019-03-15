package tech.blur.ctfbackend.api;


import tech.blur.ctfbackend.models.RecoveryKey;
import tech.blur.ctfbackend.models.UserLoginPass;
import tech.blur.ctfbackend.models.User;
import tech.blur.ctfbackend.models.UserToken;
import tech.blur.ctfbackend.services.UserService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.util.Collection;

@RestController
public class UsersController {

    private static final String USERS_PATH = "/users";

    @Autowired
    private UserService service;

//    @GetMapping(USERS_PATH + "/{id}")
//    public @ResponseBody
//    BaseResponse<User> readUser(@PathVariable String id) {
//        BaseResponse<User> response = new BaseResponse<>();
//        User user = service.provideUser(id);
//
//        return getUserBaseResponse(response, user);
//    }

    @PostMapping(USERS_PATH + "/recover/{id}")
    public @ResponseBody
    BaseResponse<User> recoverUser(@RequestBody RecoveryKey recoveryKey,
                                   @RequestHeader("token") String token,
                                   @PathVariable String id) {
        BaseResponse<User> response = new BaseResponse<>();
        if (!token.equals(Resources.getToken(Integer.parseInt(id)-1))){
            response.setStatus("INVALID TOKEN");
            response.setMessage("Invalid token!");
            return response;
        } else {
            User user = service.recoverUser(id, recoveryKey);
            return getUserBaseResponse(response, user);
        }
    }

//    @GetMapping(USERS_PATH)
//    public @ResponseBody
//    BaseResponse<Collection<User>> listUsers() {
//        BaseResponse<Collection<User>> response = new BaseResponse<>();
//        Collection<User> result = service.provideUsers();
//        response.setData(result);
//        return response;
//    }

    @PostMapping(USERS_PATH + "/auth")
    public @ResponseBody
    BaseResponse<UserToken> authUser(@RequestBody UserLoginPass userLoginPass) {
        BaseResponse<UserToken> response = new BaseResponse<>();
        User user = service.authUser(userLoginPass);

        if (user == null) {
            response.setStatus("USER_NOT_EXIST");
            response.setMessage("Wrong passphrase!");
        } else {
            response.setData(new UserToken(user, Resources.getToken(Integer.parseInt(user.getId())-1)));
        }
        return response;
//        return getUserBaseResponse(response, user);
    }

    @PatchMapping(USERS_PATH + "/{id}")
    public @ResponseBody
    BaseResponse<User> updateUser(@PathVariable String id,
                                  @RequestHeader("token") String token,
                                  @RequestBody User user) {
        BaseResponse<User> response = new BaseResponse<>();
        User result = service.updateUser(user);
        response.setData(result);
        return response;
    }

    private BaseResponse<User> getUserBaseResponse(BaseResponse<User> response, User user) {
        if (user == null) {
            response.setStatus("USER_NOT_EXIST");
            response.setMessage("Wrong passphrase!");
        } else {
            response.setData(user);
        }
        return response;
    }

}