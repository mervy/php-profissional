Trabalhando com git flow
Iniciar um novo projeto com Git Flow: 
git flow init

Criar uma nova branch de feature: 
git flow feature start <nome-da-feature>

Tudo ok? 
git add . 
git commit -m "Feature concluída"

Finalizar uma branch de feature: 
git flow feature finish <nome-da-feature>

Criar uma nova branch de release: 
git flow release start <versão-da-release>

Finalizar uma branch de release: 
git flow release finish <versão-da-release>

Criar uma nova branch de hotfix: 
git flow hotfix start <nome-do-hotfix>

Finalizar uma branch de hotfix: 
git flow hotfix finish <nome-do-hotfix>