package tech.blur.features.auth;

import android.content.SharedPreferences;

import com.arellomobile.mvp.InjectViewState;
import com.arellomobile.mvp.MvpPresenter;

import retrofit2.Retrofit;
import tech.blur.core.PreferencesApi;
import tech.blur.core.model.User;
import tech.blur.core.model.UserAuth;
import tech.blur.core.model.UserToken;
import tech.blur.core.network.Carry;
import tech.blur.core.network.DefaultCallback;
import tech.blur.core.network.RetrofitProvider;
import tech.blur.features.auth.api.AuthApi;

@InjectViewState
public class AuthPresenter extends MvpPresenter<AuthView> {

    private String login;
    private String pass;
    private SharedPreferences prefs;
    AuthApi api;

    AuthPresenter(){
        Retrofit retrofit = new RetrofitProvider().getRetrofit();
        api = retrofit.create(AuthApi.class);
    }


    public void setPrefs(SharedPreferences prefs) {
        this.prefs = prefs;
    }

    void onLoginChanged(String s){
        login = s;
    }

    void onPassChanged(String s){
        pass = s;
    }

    void onSignInClicked(){
        if (!pass.isEmpty() && !login.isEmpty()) {
            api.CheckUser(new UserAuth(login, pass)).enqueue(new DefaultCallback<>(new Carry<UserToken>() {
                @Override
                public void onSuccess(UserToken result) {
                    if (result != null) {
                        User user = result.getUser();
                        PreferencesApi.setUser(user, prefs);
                        PreferencesApi.setJwt(result.getToken(), prefs);
                        if (user.getTrusted() == 0) getViewState().openRecovery();
                        else getViewState().openMainActivity();
                    } else getViewState().showMessage("Auth failed");
                }

                @Override
                public void onFailure(Throwable throwable) {
                    getViewState().showMessage("Auth failed");
                }
            }));
        }
    }

}
