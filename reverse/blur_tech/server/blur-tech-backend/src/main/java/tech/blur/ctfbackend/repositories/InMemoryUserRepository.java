package tech.blur.ctfbackend.repositories;

import tech.blur.ctfbackend.api.Resources;
import tech.blur.ctfbackend.models.RecoveryKey;
import tech.blur.ctfbackend.models.UserLoginPass;
import tech.blur.ctfbackend.models.User;
import org.springframework.stereotype.Repository;

import java.util.*;


@Repository
public class InMemoryUserRepository implements UserRepository {

    private Map<String, User> userCache = new HashMap<>();

    private Map<UserLoginPass, User> userLoginPass = new HashMap<>();

    private ArrayList<String> tokens = new ArrayList<>();

    private final String RECOVERY_KEY = "agDzPnj9YmgL4FB3GS8m";

    public InMemoryUserRepository() {
        int i = 1;
        userCache.put(Integer.toString(i), new User(Integer.toString(i++), "MacOSO", "verystrongpassword", "Саша",  0));
        userCache.put(Integer.toString(i), new User(Integer.toString(i++), "SrgGrch", "qwer2017", "Серёжа", 0));
        userCache.put(Integer.toString(i), new User(Integer.toString(i++), "rm404", "ozpbjhhssc", "rm404", 0));
        userCache.put(Integer.toString(i), new User(Integer.toString(i++), "Sibvision", "xorbpconpb", "Sibvision", 0));
        userCache.put(Integer.toString(i), new User(Integer.toString(i++), "tps", "bbcyhqphrb", "Трисомия по хромосоме", 0)); //Трисомия по хромосоме
        userCache.put(Integer.toString(i), new User(Integer.toString(i++), "CSG", "tcpbptuyke", "CSG", 0));
        userCache.put(Integer.toString(i), new User(Integer.toString(i++), "GSV", "wimgygepek", "GSV", 0));
        userCache.put(Integer.toString(i), new User(Integer.toString(i++), "L3AV", "ffornthbxq", "L3AV", 0));
        userCache.put(Integer.toString(i), new User(Integer.toString(i++), "Comanda_R", "njjwpmgzpy", "Comanda R", 0));
        userCache.put(Integer.toString(i), new User(Integer.toString(i++), "DreamTeam", "hcxleuhdxf", "DreamTeam", 0));
        userCache.put(Integer.toString(i), new User(Integer.toString(i++), "HackSQUAD", "zsednvqteg", "HackSQUAD", 0));
        userCache.put(Integer.toString(i), new User(Integer.toString(i++), ":)", "ldsyaprlrs", ":)", 0));
        userCache.put(Integer.toString(i), new User(Integer.toString(i++), "Hack_SQUAD_2.0", "lantvvwsrn", "Hack_SQUAD_2.0", 0));
        userCache.put(Integer.toString(i), new User(Integer.toString(i++), "mu574n6", "nwnutdkyow", "mu574n6", 0));
        userCache.put(Integer.toString(i), new User(Integer.toString(i++), "NeosFun", "sdzjjhjfnb", "NeosFun", 0));
        userCache.put(Integer.toString(i), new User(Integer.toString(i++), "KEVA", "yylopsahxa", "KEVA", 0));
        userCache.put(Integer.toString(i), new User(Integer.toString(i++), "DdoSIA", "advrcgfhca", "DdoSIA", 0));
        userCache.put(Integer.toString(i), new User(Integer.toString(i++), "DEEP_DARK_CTF", "asdxffdsfx", "♂DEEP♂DARK♂CTF♂", 0));
        userCache.put(Integer.toString(i), new User(Integer.toString(i++), "0x01", "fmvkdlmsds", "0x01", 0));
        userCache.put(Integer.toString(i), new User(Integer.toString(i++), "5W337_H07_P13", "ffpdsvipmv", "5W337_H07_P13", 0));
        userCache.put(Integer.toString(i), new User(Integer.toString(i++), "bib", "sivookreve", "Бибо и Бобо", 0)); //Бибо и Бобо
        userCache.put(Integer.toString(i), new User(Integer.toString(i++), "Bug_Ent.", "wvbfdvfdvv", "Bug Ent.", 0));
        userCache.put(Integer.toString(i), new User(Integer.toString(i++), "inf_lim", "gwrgbrbsfb", "inf≠lim", 0));
        userCache.put(Integer.toString(i), new User(Integer.toString(i++), "Los_Pollitos", "svlsvlervd", "Los Pollitos", 0));
        userCache.put(Integer.toString(i), new User(Integer.toString(i++), "D34", "poiremgioe", "D34ᵗʰ", 0));
        userCache.put(Integer.toString(i), new User(Integer.toString(i++), "4N1m3.go.Nо", "sdnlfnsdff", "4N1m3.go.Nо", 0));
        fillUserLoginPassCache();


        //userLoginPass.put(new UserLoginPass("MacOSO", "verystrongpassword"), userCache.get("1"));
        //userLoginPass.put(new UserLoginPass("SrgGrch", "qwer2017"), userCache.get("2"));
    }
    
    private void fillUserLoginPassCache(){
        for (int i = 1; i <= userCache.size(); i++){
            userLoginPass.put(new UserLoginPass(userCache.get(Integer.toString(i)).getLogin(),
                    userCache.get(Integer.toString(i)).getPassword()), userCache.get(Integer.toString(i)));
            Resources.setToken(userCache.get(Integer.toString(i)).getPassword());
        }
    }


    public String getToken(int id){
        return tokens.get(id);
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
