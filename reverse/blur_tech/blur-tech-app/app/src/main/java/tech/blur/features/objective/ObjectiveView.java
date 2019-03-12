package tech.blur.features.objective;

import com.arellomobile.mvp.MvpView;

import tech.blur.core.model.Objective;

public interface ObjectiveView extends MvpView {
    void loadObjective(Objective objective);
    void showMessage(String s);
}
