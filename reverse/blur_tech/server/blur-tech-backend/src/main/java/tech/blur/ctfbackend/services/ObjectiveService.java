package tech.blur.ctfbackend.services;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import tech.blur.ctfbackend.models.Objective;
import tech.blur.ctfbackend.repositories.ObjectiveRepository;

@Service
public class ObjectiveService {

    private final ObjectiveRepository objectiveRepository;

    @Autowired
    public ObjectiveService(ObjectiveRepository objectiveRepository) {
        this.objectiveRepository = objectiveRepository;
    }

    public Objective getObjective(){
        return objectiveRepository.getObjective();
    }
}
