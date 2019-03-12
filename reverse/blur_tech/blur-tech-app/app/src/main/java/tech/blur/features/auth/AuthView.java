package tech.blur.features.auth;

import com.arellomobile.mvp.MvpView;

public interface AuthView extends MvpView {
    void showMessage(String s);
    void openRecovery();
    void openMainActivity();

}
