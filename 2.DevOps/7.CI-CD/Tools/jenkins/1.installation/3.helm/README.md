helm repo add jenkins https://charts.jenkins.io
helm repo update
helm search repo jenkins

kubectl create namespace jenkins
kubectl apply -f sa.yaml

kubectl apply -f pv.yaml
minikube ssh
sudo chown -R 1000:1000 /data/jenkins-volume
exit

helm install jenkins -n jenkins -f jnk-values.yaml jenkins/jenkins

username = admin
password = 
           kubectl exec --namespace jenkins -it svc/jenkins-release -c jenkins -- /bin/cat /run/secrets/additional/chart-admin-password

minikube service jenkins-release -n jenkins