package tech.blur.features.objective;

import com.arellomobile.mvp.InjectViewState;
import com.arellomobile.mvp.MvpPresenter;

import tech.blur.core.network.Carry;
import tech.blur.core.network.DefaultCallback;
import tech.blur.core.network.RetrofitProvider;
import tech.blur.core.Token;
import tech.blur.core.model.Objective;
import tech.blur.features.objective.api.ObjectiveApi;

@InjectViewState
public class ObjectiveActivityPresenter extends MvpPresenter<ObjectiveView> {

    private ObjectiveApi api = new RetrofitProvider().getRetrofit().create(ObjectiveApi.class);

    void getObjective() {
        api.getObjective(Token.getToken()).enqueue(new DefaultCallback<>(new Carry<Objective>() {
            @Override
            public void onSuccess(Objective result) {
                if (result != null)
                    getViewState().loadObjective(result);
            }

            @Override
            public void onFailure(Throwable throwable) {
                getViewState().showMessage(throwable.toString());
            }
        }));
    }
}
