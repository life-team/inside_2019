package tech.blur.ctfbackend.repositories;

import org.springframework.stereotype.Repository;
import tech.blur.ctfbackend.models.Objective;

@Repository
public class InMemoryObjectiveRepository implements ObjectiveRepository {

    private Objective mainObjective = new Objective("Directive #2457", "Agent Jarrett, forget about your previous " +
            "mission, our priorities changed, now you need to gain access to main server in JTF HQ. We send you special " +
            "access key, which will help you to penetrate JTF HQ ", "CTF{dGhhdCdzIDQy}");

    @Override
    public Objective getObjective() {
        return mainObjective;
    }
}
