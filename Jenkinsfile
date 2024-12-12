pipeline {
    agent any
    environment {
        GIT_SSH_COMMAND = "ssh -i /path/to/your/ssh.key"
    }
    triggers {
        githubPush()
    }
    stages {
        stage('Pipeline Triggered Successfully') {
            steps {
                echo 'The pipeline has been triggered successfully by GitHub push.'
            }
        }
        stage('Checkout') {
            steps {
                git url: 'git@github.com:goldybawa48/www.goldy.today.git', branch: 'main'
            }
        }
        stage('Deploy Code') {
            steps {
                sh '''
                ssh -i /var/lib/jenkins/workspace/ssh-key.pem -o StrictHostKeyChecking=no ubuntu@3.139.107.216 \
                "cd /var/www/html/www.goldy.today && sudo git pull origin main"
                '''
            }
        }
    }
    post {
        success {
            echo 'Pipeline completed successfully!'
        }
        failure {
            echo 'Pipeline failed.'
        }
        always {
            echo 'Pipeline execution finished, regardless of success or failure.'
        }
    }
}
