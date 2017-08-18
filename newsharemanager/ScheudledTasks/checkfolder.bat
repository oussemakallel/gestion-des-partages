@echo off
net use \\%1\%4$ /user:%2 %3
IF EXIST \\%1\%4$\%5 ( echo SUCCESS ) else ( echo FAIL )