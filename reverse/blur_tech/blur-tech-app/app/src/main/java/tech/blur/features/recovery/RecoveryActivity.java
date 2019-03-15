package tech.blur.features.recovery;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.Window;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.arellomobile.mvp.presenter.InjectPresenter;

import java.util.Objects;

import tech.blur.core.DefaultTextWatcher;
import tech.blur.core.PreferencesApi;
import tech.blur.nstuctf.R;
import tech.blur.core.moxy.MvpAndroidxActivity;
import tech.blur.features.objective.ObjectiveActivity;

public class RecoveryActivity extends MvpAndroidxActivity implements RecoveryView {


    @InjectPresenter
    RecoveryPresenter presenter;


    public static void start(Context context) {
        final Intent intent = new Intent(context, RecoveryActivity.class);
        context.startActivity(intent);
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);


        setContentView(R.layout.activity_recovery);

        presenter.setPrefs(getSharedPreferences(
                PreferencesApi.sharedPreferencesName,
                Context.MODE_PRIVATE
        ));

        final EditText recoveryPassphrase = findViewById(R.id.recovery_passphrase);
        Button recover = findViewById(R.id.recover_button);

        recoveryPassphrase.addTextChangedListener(new DefaultTextWatcher() {
            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {
                presenter.onPassphraseChanged(s.toString());
            }
        });

        recover.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if (!recoveryPassphrase.getText().toString().isEmpty())
                    presenter.onRecoveryClicked();
                else
                    Toast.makeText(getApplicationContext(), "wrong passphrase", Toast.LENGTH_SHORT).show();
            }
        });

    }

    @Override
    public void onBackPressed() {

    }

    @Override
    public void showMessage(String s) {
        Toast.makeText(getApplicationContext(), s, Toast.LENGTH_SHORT).show();
    }

    @Override
    public void onRecoveryComplete() {
        ObjectiveActivity.start(this);
    }
}
