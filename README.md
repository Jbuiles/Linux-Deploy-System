# Linux-Deploy-System

#What is it?
This is a Linux Package deployment system intended to be used to deliver system and application packages to other servers or virtual machines within your network. It is intended to be setup and used within a three tiered server framework (Development, Quality Assurance and Production.) In addition, there is another server(Orchestration) used in this model which is designed to handle communication between the other three servers using RabbitMQ via AMQP(Advanced Messaging Queueing Protocol). This deployment system is designed for businesses and development teams who want to ensure maximum uptime for their applications while minimizing potential bugs or unwanted code getting into their live production applications.


#How does it work?
Whenever there is a new version available for your files or application, this system will automatically deploy the packages and files to a desired location on the the Quality Assurance server for testing before being sent to the production server for live use.

#Disclaimer
This project is still under construction and code or features may change or vary at any point. I am not responsible for any losses or damages you incur if you decide to use this system.
