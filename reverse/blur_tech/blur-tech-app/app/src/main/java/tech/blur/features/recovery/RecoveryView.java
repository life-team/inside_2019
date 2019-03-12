package tech.blur.features.recovery;

import com.arellomobile.mvp.MvpView;

public interface RecoveryView extends MvpView {
    void showMessage(String s);
    void onRecoveryComplete();
}
