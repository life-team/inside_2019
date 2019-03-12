package tech.blur.core.model;

public class UserToken {
    private String token;
    private User user;

    public UserToken(String token, User user) {
        this.token = token;
        this.user = user;
    }

    public String getToken() {
        return token;
    }

    public User getUser() {
        return user;
    }
}
