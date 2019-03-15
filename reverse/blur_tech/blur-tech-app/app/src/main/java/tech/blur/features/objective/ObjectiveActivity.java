package tech.blur.features.objective;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.view.Window;
import android.widget.TextView;
import android.widget.Toast;

import com.arellomobile.mvp.presenter.InjectPresenter;

import java.util.Objects;

import tech.blur.nstuctf.R;
import tech.blur.core.model.Objective;
import tech.blur.core.moxy.MvpAndroidxActivity;

public class ObjectiveActivity extends MvpAndroidxActivity implements ObjectiveView {

    @InjectPresenter
    ObjectiveActivityPresenter presenter;

    private TextView name;
    private TextView content;
    private TextView key;


    public static void start(Context context){
        final Intent intent = new Intent(context, ObjectiveActivity.class);

        //intent.putExtra("isAuth", isAuthAc);
        context.startActivity(intent);
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        setContentView(R.layout.activity_objective);

        name = findViewById(R.id.objective_name);
        content = findViewById(R.id.objective_content);
        key = findViewById(R.id.objective_key);

        presenter.getObjective();

    }

    @Override
    public void onBackPressed() {

    }

    @Override
    public void loadObjective(Objective objective) {
        key.setText(objective.getKey());
        name.setText(objective.getName());
        content.setText(objective.getDescription());
    }

    @Override
    public void showMessage(String s) {
        Toast.makeText(this, s, Toast.LENGTH_SHORT).show();
    }
}
