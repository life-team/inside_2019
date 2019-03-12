package tech.blur.ctfbackend.repositories;

import tech.blur.ctfbackend.models.RecoveryKey;
import tech.blur.ctfbackend.models.UserLoginPass;
import tech.blur.ctfbackend.models.User;
import org.springframework.stereotype.Repository;

import java.util.*;


@Repository
public class InMemoryUserRepository implements UserRepository {

    private Map<String, User> userCache = new HashMap<>();

    private Map<UserLoginPass, User> userLoginPass = new HashMap<>();

    private final String RECOVERY_KEY = "agDzPnj9YmgL4FB3GS8m";

    public InMemoryUserRepository() {
        userCache.put("1", new User("1", "MacOSO", "verystrongpassword", "Саша",  0));
        userCache.put("2", new User("2", "SrgGrch", "qwer2017", "Серёжа", 0));
        userCache.put("3", new User("3", "ctf", "1234", "ctf", 0));
        fillUserLoginPassCache();


        //userLoginPass.put(new UserLoginPass("MacOSO", "verystrongpassword"), userCache.get("1"));
        //userLoginPass.put(new UserLoginPass("SrgGrch", "qwer2017"), userCache.get("2"));
    }
    
    private void fillUserLoginPassCache(){
        for (int i = 1; i <= userCache.size(); i++){
            userLoginPass.put(new UserLoginPass(userCache.get(Integer.toString(i)).getLogin(),
                    userCache.get(Integer.toString(i)).getPassword()), userCache.get(Integer.toString(i)));
        }
    }


    @Override
    public User fetchUser(final String id) {
        return userCache.get(id);
    }

    @Override
    public User updateUser(final User user) {
        userCache.put(user.getId(), user);
        return user;
    }

    @Override
    public User authUser(UserLoginPass userLoginPass) {
        return this.userLoginPass.get(userLoginPass);
    }

    @Override
    public void deleteUser(final String id) {
        userCache.remove(id);
    }

    @Override
    public User createUser(final User user) {
        user.setId(Integer.toString(userCache.size()+1));
        userCache.put(user.getId(), user);
        userLoginPass.put(new UserLoginPass(user.getLogin(), user.getPassword()), user);
        return user;
    }

    @Override
    public Collection<User> getAllUsers() {
        return userCache.values();
    }

    @Override
    public User recoveryUser(String id, RecoveryKey recoveryKey) {
        User user = userCache.get(id);
        if (recoveryKey.getKey().equals(RECOVERY_KEY)) {
            user.setTrusted(1);
            userCache.put(user.getId(), user);
            return user;
        } else {
            return null;
        }
    }
}
