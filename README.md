# Linux-Deploy-System

This is a Linux Package deployment system intended to be used to deliver system and application packages to other servers or virtual machines within your network. It is intended to be setup and used in a three tiered server framework (Development, Quality Assurance and Production.) In addition, there is another server used in this model which is designed to handle communication between the other three servers using RabbitMQ via AMQP(Advanced Messaging Queueing Protocol). When there is a new version available for your files or application, this system will automatically deploy the packages and files to a desired location on the the Quality Assurance server for testing before being sent to the production server for live use.

This project is still under construction and code or features may change or vary at any point.
