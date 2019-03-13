package tech.blur.features.recovery;

import android.content.SharedPreferences;

import com.arellomobile.mvp.InjectViewState;
import com.arellomobile.mvp.MvpPresenter;

import retrofit2.Retrofit;
import tech.blur.core.PreferencesApi;
import tech.blur.core.Token;
import tech.blur.core.model.RecoveryKey;
import tech.blur.core.model.User;
import tech.blur.core.network.Carry;
import tech.blur.core.network.DefaultCallback;
import tech.blur.core.network.RetrofitProvider;
import tech.blur.features.recovery.api.RecoverApi;

@InjectViewState
public class RecoveryPresenter extends MvpPresenter<RecoveryView> {

    private String passphrase;
    private RecoverApi api;
    private SharedPreferences prefs;

    public RecoveryPresenter() {
        Retrofit retrofit = new RetrofitProvider().getRetrofit();
        api = retrofit.create(RecoverApi.class);
    }

    void onPassphraseChanged(String s){
        passphrase = s;
    }

    void onRecoveryClicked(){
        api.recoverUser(new RecoveryKey(passphrase), PreferencesApi.getUser(prefs).getId(), Token.getToken())
                .enqueue(new DefaultCallback<>(new Carry<User>() {
                    @Override
                    public void onSuccess(User result) {

                         if (result != null) getViewState().onRecoveryComplete();
                         else getViewState().showMessage("Wrong passphrase");
                    }
                    @Override
                    public void onFailure(Throwable throwable) {
                        getViewState().showMessage("Wrong passphrase");
                    }
                }));
    }

    public void setPrefs(SharedPreferences prefs) {
        this.prefs = prefs;
    }
}
